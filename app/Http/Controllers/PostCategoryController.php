<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $postCategory = $request->only(['name', 'slug', 'description']);
        if ($request->has('picture')) {
            $path = $request->file('picture')->store('post-categories', 'public');
            $postCategory['picture'] = $path;
        }
        PostCategory::create($postCategory);
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
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $postCategory->name = $validated['name'];
        $postCategory->slug = $validated['slug'];
        $postCategory->description = $validated['description'];

        if ($request->has('picture')) {
            if ($postCategory->picture && Storage::exists('public/' . $postCategory->picture)) {
                Storage::delete('public/' . $postCategory->picture);
            }

            $path = $request->file('picture')->store('post-categories', 'public');
            $postCategory->picture = $path;
        }

        $postCategory->save();
        return redirect()->route('admin.blog-categories.edit', ['postCategory' => $postCategory->id])->with('success', 'Category updated with success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostCategory $postCategory)
    {
        if ($postCategory->picture && Storage::exists('public/' . $postCategory->picture)) {
            Storage::delete('public/' . $postCategory->picture);
        }
        $postCategory->delete();
        return redirect()->route('admin.blog-categories.index')->with('success', 'Category deleted with success');
    }
}
