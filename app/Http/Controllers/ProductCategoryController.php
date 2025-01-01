<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::paginate(15);
        return view('admin.shop-categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shop-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:product_categories,name',
            'description' => 'required|max:2050|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $productCategory = $request->only(['name', 'description']);
        if ($request->has('picture')) {
            $path = $request->file('picture')->store('shop-categories', 'public');
            $productCategory['picture'] = $path;
        }
        ProductCategory::create($productCategory);
        return redirect()->route('admin.shop-categories.index')->with('success', 'Product category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        return view('admin.shop-categories.edit', ['productCategory' => $productCategory]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('post_categories', 'name')->ignore($productCategory->id)
            ],
            'description' => 'required|max:2050|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $productCategory->name = $validated['name'];
        $productCategory->description = $validated['description'];

        if ($request->has('picture')) {
            $picturePath = 'public/' . $productCategory->picture;
            if (Storage::exists($picturePath)) {
                Storage::delete($picturePath);
            }
            $path = $request->file('picture')->store('shop-categories', 'public');
            $productCategory->picture = $path;
        }

        $productCategory->save();
        return redirect()->route('admin.shop-categories.edit', ['productCategory' => $productCategory->id])->with('success', 'Category updated with success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        $picturePath = 'public/' . $productCategory->picture;
        if (Storage::exists($picturePath)) {
            Storage::delete($picturePath);
        }
        $productCategory->delete();
        return back()->with('success', 'Product category deleted successfully');
    }
}
