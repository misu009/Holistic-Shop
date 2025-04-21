<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Post;
use App\Models\PostCategory;
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
        $posts = Post::paginate(15);
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|unique:posts,title',
            'description' => 'required|string',
            'slug' => 'nullable|string|regex:/^[a-z0-9-]+$/|unique:posts,slug',
            'excerpt' => 'nullable|string|max:255',
            'post_category' => 'required|array',
            'post_category.*' => 'required|exists:post_categories,id',
            'media.*' => 'nullable|mimes:jpeg,png,jpg,gifjpeg,png,jpg,gif,mp4,mov,avi|max:40480',
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['title']) . '-' . uniqid();
        $excerpt = $validated['excerpt'];
        if (!$excerpt) {
            $words = str_word_count(strip_tags($validated['description']), 1);
            $excerpt = implode(' ', array_slice($words, 0, 5));
        }

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => $slug,
            'excerpt' => $excerpt,
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
            'description' => 'required|string',
            'post_category' => 'required|array',
            'post_category.*' => 'required|exists:post_categories,id',
            'media.*' => 'nullable|mimes:jpeg,png,jpg,gifjpeg,png,jpg,gif,mp4,mov,avi|max:40480',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']) . '-' . uniqid();
        if (!$validated['excerpt']) {
            $words = str_word_count(strip_tags($validated['description']), 1);
            $excerpt = implode(' ', array_slice($words, 0, 5));
            $validated['excerpt'] = count($words) > 5 ? $excerpt . '...' : implode(' ', $words);
        }

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $content = $post->description; // assuming 'description' holds CKEditor HTML

        preg_match_all('/<img[^>]+src="([^">]+)"/i', $content, $matches);
        $imageUrls = $matches[1]; // List of src values
        foreach ($imageUrls as $url) {
            // Step 3: Convert URL to storage path (if public disk used)
            $filePath = str_replace(asset('storage/'), '', $url);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }
        foreach ($post->media as $media) {
            if (Storage::exists('public/' . $media->path)) {
                Storage::delete('public/' . $media->path);
            }
        }
        $post->delete();
        ActivityLogger::log('Created a post', 'Post', $post->id);
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
        $allPosts = Post::get()->map(function ($post) {
            $post->class = 'App\Models\Post';
            $post->name = $post->title; // This is the name that will be displayed in the search
            return $post;
        });
        $allCategories = PostCategory::get()->map(function ($postCategory) {
            $postCategory->class = 'App\Models\PostCategory';
            return $postCategory;
        });
        $mergedResult = $allPosts->merge($allCategories);
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
            $products = Post::get();
            $this->addPostSearch($products, $searchItems);
        } elseif ($value === 2) {
            $products = Post::get();
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
