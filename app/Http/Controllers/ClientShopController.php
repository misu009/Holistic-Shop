<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientShopController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get the search query if it exists
        $query = $request->input('query');

        // 2. Build the query
        $products = Product::orderBy('order')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->paginate(12)
            ->withQueryString()
            ->fragment('shop-product'); // Keeps the ?query=... in the URL when changing pages!

        // 3. Get settings (Notice you had this typed twice in your original index method!)
        $settings = Setting::first() ?? new Setting();

        return view('client.shop.index', compact('products', 'settings', 'query'));
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
