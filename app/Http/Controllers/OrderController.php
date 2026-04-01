<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function trackForm(Request $request)
    {
        return view('orders.track', ['order' => null]);
    }

    public function track(Request $request)
    {
        $validated = $request->validate([
            'order_id' => ['required', 'integer'],
        ]);

        $order = $request->user()->orders()
            ->with('items')
            ->find($validated['order_id']);

        if (! $order) {
            return back()->withErrors(['order_id' => 'Order not found.'])->withInput();
        }

        return view('orders.track', ['order' => $order]);
    }

    public function history(Request $request)
    {
        return view('orders.history', [
            'orders' => $request->user()->orders()->with('items')->latest('ordered_at')->paginate(10),
        ]);
    }

    public function show(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $order->load('items');

        return view('orders.show', [
            'order' => $order,
        ]);
    }

    public function thankYou(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $order->load('items');

        return view('orders.thankyou', compact('order'));
    }
}
