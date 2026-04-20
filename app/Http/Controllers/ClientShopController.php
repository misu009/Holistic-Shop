<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientShopController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::first() ?? new Setting();
        $categories = ProductCategory::orderBy('order', 'asc')->paginate(12);
        return view('client.shop.index', compact('categories', 'settings'));
    }

    public function category(Request $request, $id)
    {
        $settings = Setting::first() ?? new Setting();
        $category = ProductCategory::findOrFail($id);
        $query = $request->input('query');
        $products = $category->products()
            ->orderBy('order')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->paginate(12)
            ->withQueryString()
            ->fragment('shop-product');
        return view('client.shop.category', compact('category', 'products', 'settings', 'query'));
    }

    public function show($slug)
    {
        $settings = Setting::first() ?? new Setting();
        $product = Product::where('slug', $slug)->firstOrFail();

        $selectedProducts = Product::select('products.*')
            ->join('category_products as cp1', 'products.id', '=', 'cp1.product_id')
            ->join('category_products as cp2', function ($join) use ($product) {
                $join->on('cp1.product_category_id', '=', 'cp2.product_category_id')
                    ->where('cp2.product_id', '=', $product->id);
            })
            ->where('products.id', '!=', $product->id)
            ->distinct()
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('client.shop.show', compact('product', 'selectedProducts', 'settings'));
    }
}
