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
        // 1. Get the "skinny" cart [product_id => quantity]
        $cart = session()->get('cart', []);

        // 2. Fetch fresh products from the database
        $products = Product::with('media')->whereIn('id', array_keys($cart))->get();

        $total = 0;
        $cartItems = [];

        // 3. Build the cart array for the view using real-time database data
        foreach ($products as $product) {
            $quantity = $cart[$product->id];
            $total += $product->price * $quantity;

            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity
            ];
        }

        $settings = Setting::first() ?? new Setting();
        $countries = collect((new ISO3166())->all())->pluck('name', 'alpha2');
        $tosPage = \App\Models\Page::where('slug', 'termeni-si-conditii')->first();
        // Pass $cartItems instead of the raw session $cart
        return view('client.cart.index', compact('cartItems', 'total', 'settings', 'countries', 'tosPage'));
    }

    public function add(Request $request, $id)
    {
        // Just verify the product exists before adding
        Product::findOrFail($id);

        $cart = session()->get('cart', []);

        // Only store the quantity linked to the ID
        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produs adăugat în coș!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id] = max(1, (int)$request->quantity);
            session()->put('cart', $cart);
        }

        return redirect()->route('client.cart.index')->with('success', 'Coș actualizat cu succes!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('client.cart.index')->with('success', 'Produs șters din coș!');
    }

    public function clear()
    {
        session()->forget('cart');

        // FIXED BUG: Your original code said 'cart.index', but it should be 'client.cart.index'
        return redirect()->route('client.cart.index')->with('success', 'Coșul a fost golit!');
    }
}
