<?php

namespace App\Http\Controllers;

use App\Mail\AdminOrderNotificationMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ClientOrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_type' => 'required|in:natural,legal',
            'full_name' => 'required_if:client_type,natural|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:30',
            'birth_date' => 'required_if:client_type,natural|date|before_or_equal:' . now()->subYears(10)->format('Y-m-d'),
            'country' => 'required|string|size:2',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500',
            'company_name' => 'exclude_unless:client_type,legal|required|string|max:255',
            'company_cui' => 'exclude_unless:client_type,legal|required|string|max:50',
            'company_reg' => 'exclude_unless:client_type,legal|nullable|string|max:50',
            'company_address' => 'exclude_unless:client_type,legal|required|string|max:255',
            'agree_terms' => 'accepted',
            'agree_terms2' => 'accepted',
        ], [
            'agree_terms.accepted' => 'Trebuie să bifezi checkboxurile pentru a trimite comanda.',
            'agree_terms2.accepted' => 'Trebuie să bifezi checkboxurile pentru a trimite comanda.',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Coșul este gol.');
        }

        $productIds = array_keys($cart);

        $realProducts = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $total = 0;
        $orderItemsData = [];

        foreach ($cart as $productId => $quantity) {
            $realProduct = $realProducts->get($productId);

            if (!$realProduct) continue;

            $currentPrice = $realProduct->price;

            $total += ($currentPrice * $quantity);

            $orderItemsData[] = [
                'product_id' => $productId,
                'product_name' => $realProduct->name,
                'quantity' => $quantity,
                'price' => $currentPrice,
            ];
        }
        $order = Order::create([...$validated, 'total' => $total]);

        foreach ($orderItemsData as $itemData) {
            $order->items()->create($itemData); // Assumes you have an items() relationship on Order
        }
        $settings = Setting::first();
        $order->load('items');
        Mail::to($settings->email)->send(new AdminOrderNotificationMail($order));

        session()->forget('cart');

        return redirect()->route('client.cart.index')
            ->with('ordered', 'Mulțumim cu recunoștință pentru comanda! Fii binecuvântat!');
    }
}