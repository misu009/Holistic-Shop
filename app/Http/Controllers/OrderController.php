<?php

namespace App\Http\Controllers;

use App\Models\Enums\Order\OrderStatusEnum;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::orderByRaw("
        FIELD(status, ?, ?, ?, ?)
    ", [
            OrderStatusEnum::PENDING()->value,
            OrderStatusEnum::PROCESSING()->value,
            OrderStatusEnum::COMPLETED()->value,
            OrderStatusEnum::CANCELLED()->value,
        ])
            ->orderByDesc('created_at')
            ->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->status = $validated['status'];
        $order->save();

        return redirect()->back()->with('success', 'Statusul comenzii a fost actualizat!');
    }
}