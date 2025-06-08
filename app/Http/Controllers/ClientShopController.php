<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientShopController extends Controller
{
    public function index()
    {
        $settings = Setting::first() ?? new Setting();
        $products = Product::orderBy('order')->paginate(12);
        $settings = Setting::first() ?? new Setting();;
        return view('client.shop.index', compact('products', 'settings'));
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

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', '%' . $query . '%')->paginate(12);
        $settings = Setting::first() ?? new Setting();
        return view('client.shop.index', compact('products', 'settings', 'query'));
    }
}
