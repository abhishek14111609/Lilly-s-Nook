<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'total_sales' => Order::where('status', '!=', 'canceled')->sum('total'),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_customers' => User::where('is_admin', false)->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('metrics', 'recentOrders'));
    }
}
