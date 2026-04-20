<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
// ADD THESE TWO IMPORTS:
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::orderBy('order', 'asc')->paginate(15);
        return view('admin.shop-categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.shop-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:product_categories,name',
            'description' => 'required|max:2050|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer|min:0'
        ]);

        $productCategory = $request->only(['name', 'description']);
        $productCategory['order'] = $request->input('order') ?? 99999;

        if ($request->hasFile('picture')) {
            $manager = new ImageManager(new Driver());
            $filename = 'shop-categories/' . uniqid('cat_') . '.webp';

            // Read, Resize, and Encode to WebP
            $image = $manager->read($request->file('picture'));
            $encodedImage = $image->scaleDown(width: 800)->toWebp(quality: 85); // Increased quality slightly for crispness

            // Save to public disk
            Storage::disk('public')->put($filename, $encodedImage->toString());

            $productCategory['picture'] = $filename;
        }

        $productCategory = ProductCategory::create($productCategory);
        ActivityLogger::log('Added a new product category', 'ProductCategory', $productCategory->id);

        return redirect()->route('admin.shop-categories.index')->with('success', 'Product category created successfully');
    }

    public function show(ProductCategory $productCategory)
    {
        //
    }

    public function edit(ProductCategory $productCategory)
    {
        return view('admin.shop-categories.edit', ['productCategory' => $productCategory]);
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                // FIXED: Changed 'post_categories' to 'product_categories'
                Rule::unique('product_categories', 'name')->ignore($productCategory->id)
            ],
            'description' => 'required|max:2050|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer|min:0'
        ]);

        $productCategory->name = $validated['name'];
        $productCategory->description = $validated['description'];
        $productCategory->order = $request->input('order') ?? 99999;

        if ($request->hasFile('picture')) {
            // 1. Delete the old picture safely
            if ($productCategory->picture && Storage::disk('public')->exists($productCategory->picture)) {
                Storage::disk('public')->delete($productCategory->picture);
            }

            // 2. Process the new picture
            $manager = new ImageManager(new Driver());
            $filename = 'shop-categories/' . uniqid('cat_') . '.webp';

            $image = $manager->read($request->file('picture'));
            $encodedImage = $image->scaleDown(width: 800)->toWebp(quality: 85);

            Storage::disk('public')->put($filename, $encodedImage->toString());

            $productCategory->picture = $filename;
        }

        $productCategory->save();
        ActivityLogger::log('Updated a product category', 'ProductCategory', $productCategory->id);

        return redirect()->route('admin.shop-categories.edit', ['productCategory' => $productCategory->id])->with('success', 'Category updated with success');
    }

    public function destroy(ProductCategory $productCategory)
    {
        // Safer deletion logic to match how we save it
        if ($productCategory->picture && Storage::disk('public')->exists($productCategory->picture)) {
            Storage::disk('public')->delete($productCategory->picture);
        }

        $productCategory->delete();
        ActivityLogger::log('Deleted a product category', 'ProductCategory', $productCategory->id);

        return back()->with('success', 'Product category deleted successfully');
    }
}
