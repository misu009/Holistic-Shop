<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = PostCategory::paginate(15);
        return view('admin.blog-categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:post_categories,name',
            'slug' => 'required|max:50|string',
            'description' => 'required|max:2050|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $postCategory = $request->only(['name', 'slug', 'description']);

        if ($request->hasFile('picture')) {
            $manager = new ImageManager(new Driver());
            $filename = 'post-categories/' . uniqid('pcat_') . '.webp';

            $image = $manager->read($request->file('picture'));
            $encodedImage = $image->scaleDown(width: 800)->toWebp(quality: 85);

            Storage::disk('public')->put($filename, $encodedImage->toString());

            $postCategory['picture'] = $filename;
        }

        $category = PostCategory::create($postCategory);
        ActivityLogger::log('Created a post category', 'PostCategory', $category->id);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PostCategory $postCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostCategory $postCategory)
    {
        return view('admin.blog-categories.edit', ['postCategory' => $postCategory]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PostCategory $postCategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('post_categories', 'name')->ignore($postCategory->id),
            ],
            'slug' => 'required|max:50|string',
            'description' => 'required|max:2050|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $postCategory->name = $validated['name'];
        $postCategory->slug = $validated['slug'];
        $postCategory->description = $validated['description'];

        if ($request->hasFile('picture')) {
            // Safely delete the old picture
            if ($postCategory->picture && Storage::disk('public')->exists($postCategory->picture)) {
                Storage::disk('public')->delete($postCategory->picture);
            }

            // Process the new picture
            $manager = new ImageManager(new Driver());
            $filename = 'post-categories/' . uniqid('pcat_') . '.webp';

            $image = $manager->read($request->file('picture'));
            $encodedImage = $image->scaleDown(width: 800)->toWebp(quality: 85);

            Storage::disk('public')->put($filename, $encodedImage->toString());

            $postCategory->picture = $filename;
        }
        $postCategory->save();
        ActivityLogger::log('Updated a post category', 'PostCategory', $postCategory->id);

        return redirect()->route('admin.blog-categories.edit', ['postCategory' => $postCategory->id])->with('success', 'Category updated with success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostCategory $postCategory)
    {
        // Safely delete the image from the public disk
        if ($postCategory->picture && Storage::disk('public')->exists($postCategory->picture)) {
            Storage::disk('public')->delete($postCategory->picture);
        }

        $postCategory->delete();
        ActivityLogger::log('Deleted a post category', 'PostCategory', $postCategory->id);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Category deleted with success');
    }
}
