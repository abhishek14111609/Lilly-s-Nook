<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->toString();
        $query = Order::query()->with('user')->latest();

        if ($status && in_array($status, ['placed', 'processing', 'shipped', 'delivered', 'canceled'])) {
            $query->where('status', $status);
        }

        return view('admin.orders.index', [
            'orders' => $query->paginate(15)->withQueryString(),
            'currentStatus' => $status,
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['items', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:placed,processing,shipped,delivered,canceled'],
        ]);

        $order->update($validated);

        return back()->with('status', 'Order status updated successfully.');
    }}
