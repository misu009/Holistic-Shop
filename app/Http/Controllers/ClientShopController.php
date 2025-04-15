<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class ClientShopController extends Controller
{
    public function index()
    {
        $products = Product::paginate(12);
        $settings = Setting::first() ?? new Setting();;
        return view('client.shop.index', compact('products', 'settings'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $selectedProducts = $product->categories[0]->products
            ->where('id', '!=', $product->id)->take(4);

        return view('client.shop.show', compact('product', 'selectedProducts'));
    }
}
