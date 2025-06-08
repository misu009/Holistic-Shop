<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostMedia;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\admin\MediaContentTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use MediaContentTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('order')->paginate(15);
        $searchItems = $this->getSearchItems();
        return view('admin.posts.index', ['posts' => $posts, 'searchItems' => $searchItems]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PostCategory::get();
        return view('admin.posts.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    protected function previewPost(Request $request, ?Post $existingPost = null)
    {
        $validated = $request->validate([
            'title' => 'required|string|unique:posts,title' . ($existingPost ? ',' . $existingPost->id : ''),
            'slug' => 'nullable|string|regex:/^[a-z0-9-]+$/|unique:posts,slug' . ($existingPost ? ',' . $existingPost->id : ''),
            'excerpt' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'description' => 'required|string',
            'post_category' => 'required|array',
            'post_category.*' => 'required|exists:post_categories,id',
            'media.*' => 'nullable|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:40480',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']) . '-' . uniqid();

        if (!$validated['excerpt']) {
            $words = str_word_count(strip_tags($validated['description']), 1);
            $excerpt = implode(' ', array_slice($words, 0, 5));
            $validated['excerpt'] = count($words) > 5 ? $excerpt . '...' : implode(' ', $words);
        }

        $validated['created_by'] = auth()->user()->name;

        $mediaPreview = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $index => $file) {
                $tempPath = $file->store('temp', 'public'); // store in storage/app/public/temp
                $mediaPreview[] = (object)[
                    'path' => $tempPath,
                    'order' => $index + 1,
                ];
            }
        }
        if ($existingPost && $existingPost->media) {
            foreach ($existingPost->media as $index => $media) {
                $mediaPreview[] = (object)[
                    'path' => $media->path,
                    'order' => $index + 1,
                ];
            }
        }

        // Fake a Post instance to reuse the existing Blade view
        $post = $existingPost ?? new Post();
        $post->fill($validated);
        $post->id = $existingPost->id ?? 0; // Prevent null ID errors in view logic

        return view('client.posts.show', [
            'post' => $post,
            'settings' => Setting::first() ?? new Setting(),
            'prevPost' => Post::first(),
            'nextPost' => Post::latest()->first(),
            'previewMedia' => $mediaPreview,
            'preview' => true,
        ]);
    }
    private function getExcerpt($description)
    {
        $descriptionJson = json_decode($description, true);

        $plainText = collect($descriptionJson['blocks'] ?? [])
            ->map(function ($block) {
                return $block['data']['text'] ?? $block['data']['title'] ?? '';
            })
            ->implode(' ');

        $plainText = strip_tags($plainText);

        $words = str_word_count($plainText, 1); // 1 = return array of words
        return implode(' ', array_slice($words, 0, 5)) . (count($words) > 5 ? '...' : '');
    }

    private function moveEditorJsTempImagesToFinal(string $descriptionJson): string
    {
        $data = json_decode($descriptionJson, true);
        if (!is_array($data) || !isset($data['blocks'])) {
            return $descriptionJson;
        }

        foreach ($data['blocks'] as &$block) {
            if ($block['type'] === 'image' && isset($block['data']['file']['url'])) {
                $url = $block['data']['file']['url'];

                // Extract just the path after /storage/
                $parsedUrl = parse_url($url);
                $relativePath = $parsedUrl['path'] ?? '';
                $relativePath = Str::after($relativePath, '/storage/'); // editorjs/tmp/xyz.jpg

                if (Str::startsWith($relativePath, 'editorjs/tmp/')) {
                    $filename = basename($relativePath);
                    $oldPath = 'editorjs/tmp/' . $filename;
                    $newPath = 'editorjs/final/' . $filename;

                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->move($oldPath, $newPath);
                        $block['data']['file']['url'] = asset('storage/' . $newPath);
                    }
                }
            }
        }
        return json_encode($data);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|unique:posts,title',
            'description' => 'required|json',
            'slug' => 'nullable|string|regex:/^[a-z0-9-]+$/|unique:posts,slug',
            'order' => 'nullable|integer',
            'excerpt' => 'nullable|string|max:255',
            'preview_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:20048',
            'post_category' => 'required|array',
            'post_category.*' => 'required|exists:post_categories,id',
            'media.*' => 'nullable|mimes:jpeg,png,jpg,gifjpeg,png,jpg,gif,mp4,mov,avi|max:40480',
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['title']) . '-' . uniqid();
        $excerpt = $validated['excerpt'];
        if (!$excerpt) {
            $excerpt = $this->getExcerpt($validated['description']);
        }
        if ($request->input('action') === 'preview') {
            return $this->previewPost($request);
        }

        if ($request->hasFile('preview_image')) {
            $validated['preview_image'] = $request->file('preview_image')->store('posts/preview_images', 'public');
        }

        $validated['description'] = $this->moveEditorJsTempImagesToFinal($validated['description']);

        $post = Post::create([
            'title' => $request->title,
            'description' => $validated['description'],
            'slug' => $slug,
            'excerpt' => $excerpt,
            'preview_image' => $validated['preview_image'] ?? null,
            'order' => $request->order ?? 99999,
            'created_by' => auth()->user()->name,
        ]);

        $post->categories()->attach($request->post_category);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $media) {
                $path = $media->store('posts', 'public');
                $post->media()->create([
                    'path' => $path,
                    'order' => $post->media()->count() + 1,
                ]);
            }
        }

        ActivityLogger::log('Created a post', 'Post', $post->id);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $postCategories = PostCategory::get();
        return view('admin.posts.edit', ['post' => $post, 'categories' => $postCategories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|unique:posts,title,' . $post->id,
            'slug' => 'nullable|string|regex:/^[a-z0-9-]+$/|unique:posts,slug,' . $post->id,
            'excerpt' => 'nullable|string|max:255',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:20048',
            'order' => 'nullable|integer',
            'description' => 'required|json',
            'post_category' => 'required|array',
            'post_category.*' => 'required|exists:post_categories,id',
            'media.*' => 'nullable|mimes:jpeg,png,jpg,gifjpeg,png,jpg,gif,mp4,mov,avi|max:40480',
        ]);
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']) . '-' . uniqid();
        if (!$validated['excerpt']) {
            $validated['excerpt'] = $this->getExcerpt($validated['description']);
        }
        $validated['created_by'] = auth()->user()->name;

        if ($request->input('action') === 'preview') {
            return $this->previewPost($request, $post);
        }

        if ($request->hasFile('preview_image')) {
            if ($post->preview_image && Storage::disk('public')->exists($post->preview_image)) {
                Storage::disk('public')->delete($post->preview_image);
            }
            $validated['preview_image'] = $request->file('preview_image')->store('posts/preview_images', 'public');
        }

        $validated['description'] = $this->moveEditorJsTempImagesToFinal($validated['description']);


        $post->update($validated);

        $post->categories()->sync($request->post_category);

        $maxOrder = $post->media()->max('order');
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $media) {
                $path = $media->store('posts', 'public');
                $post->media()->create([
                    'path' => $path,
                    'order' => $maxOrder + 1,
                ]);
                $maxOrder++;
            }
        }

        ActivityLogger::log('Updated a post', 'Post', $post->id);

        return redirect()->route('admin.posts.edit', ['post' => $post->id])->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        // Delete EditorJS embedded images from JSON
        $content = $post->description;

        try {
            $editorData = json_decode($content, true);

            if (!empty($editorData['blocks']) && is_array($editorData['blocks'])) {
                foreach ($editorData['blocks'] as $block) {
                    if ($block['type'] === 'image' && isset($block['data']['file']['url'])) {
                        $url = $block['data']['file']['url'];

                        // Extract relative path from full URL
                        $relativePath = str_replace(asset('storage') . '/', '', $url);

                        if (Storage::disk('public')->exists($relativePath)) {
                            Storage::disk('public')->delete($relativePath);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            
        }

        // Delete associated media (if any)
        foreach ($post->media as $media) {
            if (Storage::exists('public/' . $media->path)) {
                Storage::delete('public/' . $media->path);
            }
        }

        // Delete preview image
        if ($post->preview_image && Storage::disk('public')->exists($post->preview_image)) {
            Storage::disk('public')->delete($post->preview_image);
        }

        // Delete post
        $post->delete();

        ActivityLogger::log('Deleted a post', 'Post', $post->id);

        return redirect()->back()->with('success', 'Post deleted with success');
    }

    public function destroyImage($postId, $imageId)
    {
        $this->deleteImage($postId, $imageId, Post::class);
        return redirect()->route('admin.posts.edit', $postId)->with('success', 'Image deleted successfully');
    }

    public function updateImage(Request $request, $postId, $imageId)
    {
        $this->changeImageOrder($postId, $imageId, Post::class);
        return redirect()->route('admin.posts.edit', $postId)->with('success', 'Image order updated successfully');
    }

    public function getSearchItems()
    {
        $allCategories = PostCategory::get()->map(function ($postCategory) {
            $postCategory->class = 'App\Models\PostCategory';
            return $postCategory;
        });
        $allPosts = Post::orderBy('order')->get()->map(function ($post) {
            $post->class = 'App\Models\Post';
            $post->name = $post->title; // This is the name that will be displayed in the search
            return $post;
        });
        $mergedResult = $allPosts->concat($allCategories);
        return $mergedResult;
    }

    public function addPostSearch(Collection $posts, Collection $searchItems)
    {
        foreach ($posts as $post) {
            $searchItems->push([
                'id' => $post->id,
                'name' => $post->title,
                'class' => 'App\Models\Post',
            ]);
        }
    }

    public function addPostCategorySearch(Collection $categories, Collection $searchItems)
    {
        foreach ($categories as $category) {
            $searchItems->push([
                'id' => $category->id,
                'name' => $category->name,
                'class' => 'App\Models\PostCategory',
            ]);
        }
    }

    public function loadSearchOptions(Request $request)
    {
        $searchItems = collect();
        $value = (int) $request->input('search-option');
        if ($value === 1) {
            $categories = PostCategory::get();
            $this->addPostCategorySearch($categories, $searchItems);
            $products = Post::orderBy('order')->get();
            $this->addPostSearch($products, $searchItems);
        } elseif ($value === 2) {
            $products = Post::orderBy('order')->get();
            $this->addPostSearch($products, $searchItems);
        } else {
            $categories = PostCategory::get();
            $this->addPostCategorySearch($categories, $searchItems);
        }
        return response()->json(['searchItems' => $searchItems]);
    }

    public function search(Request $request)
    {
        $searchOption = $request->get('search-option');
        $searchData = explode(' ', $request->get('id-class'));
        if (sizeof($searchData) != 2) {
            return back()->with('error', 'Invalid option1 for search');
        }

        $objId = $searchData[0];
        $className = $searchData[1];
        $postCatClass = 'App\Models\PostCategory';
        $postClass = 'App\Models\Post';
        if ($className != $postCatClass && $className != $postClass) {
            return back()->with('error', 'Invalid option2 for search');
        }

        if (($searchOption == 2 && $className != $postClass) or ($searchOption == 3 && $className != $postCatClass)) {
            return back()->with('error', 'Invalid option3 for search');
        }

        if ($className == $postClass) {
            $posts = collect();
            $posts->push($className::find($objId));
            $perPage = 15;
            $page = LengthAwarePaginator::resolveCurrentPage('page');

            $posts = new LengthAwarePaginator($posts->forPage($page, $perPage), $posts->count(), $perPage, $page, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]);
        } else {
            $category = $className::find($objId);
            $posts = $category->posts()->paginate(15);
        }
        $posts->appends([
            'search-option' => $searchOption,
            'id-class' => $request->get('id-class')
        ]);

        $jsonSearch = $this->loadSearchOptions($request)->content();
        $searchItems = json_decode($jsonSearch)->searchItems;
        return view('admin.posts.index', [
            'posts' => $posts,
            'searchItems' => $searchItems,
            'searchOption' => $searchOption,
            'searchRecord' => $request->get('id-class'),
        ]);
    }
}