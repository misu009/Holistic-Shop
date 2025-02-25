<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Traits\admin\MediaContentTrait;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    use MediaContentTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(15);
        $searchItems = $this->getSearchItems();
        return view('admin.products.index', ['products' => $products, 'searchItems' => $searchItems]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::get();
        return view('admin.products.create')->with(['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:product_categories,name',
            'description' => 'required|max:20050|string',
            'price' => 'decimal:0,2|required',
            'product_category' => 'required|array',
            'product_category.*' => 'required|exists:product_categories,id',
            'media.*' => 'nullable|mimes:jpeg,png,jpg,gifjpeg,png,jpg,gif,mp4,mov,avi|max:40480',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'price' => $request->price,
        ]);
        ActivityLogger::log('Added a new product', 'Product', $product->id);

        $product->categories()->attach($request->product_category);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $media) {
                $path = $media->store('products', 'public');
                $product->media()->create([
                    'path' => $path,
                    'order' => $product->media()->count() + 1,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::get();
        return view('admin.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', Rule::unique('products', 'name')->ignore($product->id),],
            'description' => 'required|max:20050|string',
            'product_category' => 'required|array',
            'product_category.*' => 'required|exists:product_categories,id',
            'price' => 'decimal:0,2|required',
            'media.*' => 'nullable|mimes:jpeg,png,jpg,gifjpeg,png,jpg,gif,mp4,mov,avi|max:40480',
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        ActivityLogger::log('Updated a product', 'Product', $product->id);

        $product->categories()->detach();
        $product->categories()->attach($request->product_category);

        $maxOrder = $product->media()->max('order');

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $media) {
                $path = $media->store('products', 'public');
                $product->media()->create([
                    'path' => $path,
                    'order' => $maxOrder + 1,
                ]);
                $maxOrder++;
            }
        }

        return redirect()->route('admin.products.edit', ['product' => $product->id])->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        foreach ($product->media as $media) {
            if (Storage::exists('public/' . $media->path)) {
                Storage::delete('public/' . $media->path);
            }
        }
        $product->delete();
        ActivityLogger::log('Deleted a product', 'Product', $product->id);
        return back()->with('success', 'Product deleted successfully');
    }

    public function addProductSearch(Collection $products, Collection $searchItems)
    {
        foreach ($products as $product) {
            $searchItems->push([
                'id' => $product->id,
                'name' => $product->name,
                'class' => 'App\Models\Product',
            ]);
        }
    }

    public function addProductCategorySearch(Collection $categories, Collection $searchItems)
    {
        foreach ($categories as $category) {
            $searchItems->push([
                'id' => $category->id,
                'name' => $category->name,
                'class' => 'App\Models\ProductCategory',
            ]);
        }
    }

    public function loadSearchOptions(Request $request)
    {
        $searchItems = collect();
        $value = (int) $request->input('search-option');
        if ($value === 1) {
            $categories = ProductCategory::get();
            $this->addProductCategorySearch($categories, $searchItems);

            $products = Product::get();
            $this->addProductSearch($products, $searchItems);
        } elseif ($value === 2) {
            $products = Product::get();
            $this->addProductSearch($products, $searchItems);
        } else {
            $categories = ProductCategory::get();
            $this->addProductCategorySearch($categories, $searchItems);
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
        $productCatClass = 'App\Models\ProductCategory';
        $productClass = 'App\Models\Product';
        if ($className != $productCatClass && $className != $productClass) {
            return back()->with('error', 'Invalid option2 for search');
        }

        if (($searchOption == 2 && $className != $productClass) or ($searchOption == 3 && $className != $productCatClass)) {
            return back()->with('error', 'Invalid option3 for search');
        }

        if ($className == $productClass) {
            $products = collect();
            $products->push($className::find($objId));
            $perPage = 15;
            $page = LengthAwarePaginator::resolveCurrentPage('page');

            $products = new LengthAwarePaginator($products->forPage($page, $perPage), $products->count(), $perPage, $page, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]);
        } else {
            $category = $className::find($objId);
            $products = $category->products()->paginate(15);
        }
        $products->appends([
            'search-option' => $searchOption,
            'id-class' => $request->get('id-class')
        ]);

        $jsonSearch = $this->loadSearchOptions($request)->content();
        $searchItems = json_decode($jsonSearch)->searchItems;
        return view('admin.products.index', [
            'products' => $products,
            'searchItems' => $searchItems,
            'searchOption' => $searchOption,
            'searchRecord' => $request->get('id-class'),
        ]);
    }

    public function getSearchItems()
    {
        $allProducts = Product::get()->map(function ($product) {
            $product->class = 'App\Models\Product';
            return $product;
        });
        $allCategories = ProductCategory::get()->map(function ($productCategory) {
            $productCategory->class = 'App\Models\ProductCategory';
            return $productCategory;
        });
        $mergedResult = $allProducts->merge($allCategories);
        return $mergedResult;
    }
    public function destroyImage($productId, $imageId)
    {
        $this->deleteImage($productId, $imageId, Product::class);
        ActivityLogger::log('Image order changed', 'Product', $productId);
        return redirect()->route('admin.products.edit', $productId)->with('success', 'Image deleted successfully');
    }

    public function updateImage(Request $request, $productId, $imageId)
    {
        $this->changeImageOrder($productId, $imageId, Product::class);
        ActivityLogger::log('Image order changed', 'Product', $productId);
        return redirect()->route('admin.products.edit', $productId)->with('success', 'Image order updated successfully');
    }
}
