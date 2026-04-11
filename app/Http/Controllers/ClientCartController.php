<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use League\ISO3166\ISO3166;

class ClientCartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $settings = Setting::first() ?? new Setting();
        $countries = collect((new ISO3166())->all())->pluck('name', 'alpha2');
        return view('client.cart.index', compact('cart', 'total', 'settings', 'countries'));
    }
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => !empty($product->media) && isset($product->media[0]) ? asset('storage/' . $product->media[0]->path) : null,
                'short_description' => $product->excerpt ?? '',
            ];
        }

        session()->put('cart', $cart);

        // Redirect back to product page with success message
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Update a product quantity.
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, (int)$request->quantity);
            session()->put('cart', $cart);
        }

        return redirect()->route('client.cart.index')->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove a single product from the cart.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('client.cart.index')->with('success', 'Product removed from cart!');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }
}