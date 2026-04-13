<?php
// Debug script to test checkout flow
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$request = \Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// Load Eloquent
$app->make('db');

// Test 1: Check database schema
echo "=== Test 1: Database Schema ===\n";
try {
    $orders = \Illuminate\Support\Facades\DB::table('orders')->first();
    if ($orders) {
        echo "✓ Orders table exists\n";
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing('orders');
        echo "Columns: " . implode(', ', $columns) . "\n";

        $required = ['payment_status', 'invoice_number', 'razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature', 'paid_at'];
        foreach ($required as $col) {
            if (in_array($col, $columns)) {
                echo "✓ Column '$col' exists\n";
            } else {
                echo "✗ MISSING Column '$col'\n";
            }
        }
    }
} catch (\Exception $e) {
    echo "✗ Error checking schema: " . $e->getMessage() . "\n";
}

// Test 2: Check Razorpay config
echo "\n=== Test 2: Razorpay Configuration ===\n";
try {
    $keyId = config('services.razorpay.key_id');
    $keySecret = config('services.razorpay.key_secret');

    if ($keyId && $keySecret) {
        echo "✓ Razorpay credentials configured\n";
        echo "  Key ID: " . substr($keyId, 0, 4) . "..." . substr($keyId, -4) . "\n";
        echo "  Key Secret: " . substr($keySecret, 0, 4) . "..." . substr($keySecret, -4) . "\n";
    } else {
        echo "✗ Razorpay credentials NOT configured\n";
    }
} catch (\Exception $e) {
    echo "✗ Error reading config: " . $e->getMessage() . "\n";
}

// Test 3: Check views
echo "\n=== Test 3: View Files ===\n";
$views = [
    'checkout.show',
    'checkout.payment',
    'orders.show',
    'orders.thankyou',
    'orders.history',
    'orders.partials.invoice',
    'admin.orders.show',
];

foreach ($views as $view) {
    $path = resource_path('views/' . str_replace('.', '/', $view) . '.blade.php');
    if (file_exists($path)) {
        echo "✓ View '$view' exists\n";
    } else {
        echo "✗ View '$view' MISSING\n";
    }
}

// Test 4: Check routes
echo "\n=== Test 4: Routes ===\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $routeList = collect($routes->getRoutes());
    $checkout_routes = $routeList->filter(fn($route) => $route->uri() === 'checkout');
    $razorpay_routes = $routeList->filter(fn($route) => $route->uri() === 'checkout/razorpay/verify');

    echo "✓ " . count($checkout_routes) . " checkout routes found\n";
    echo "✓ " . count($razorpay_routes) . " razorpay verify routes found\n";
} catch (\Exception $e) {
    echo "✗ Error checking routes: " . $e->getMessage() . "\n";
}

// Test 5: Check Order model
echo "\n=== Test 5: Order Model ===\n";
try {
    $order = new \App\Models\Order();
    $fillable = $order->getFillable();

    $required_fields = ['payment_method', 'payment_status', 'invoice_number', 'razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature', 'paid_at'];

    foreach ($required_fields as $field) {
        if (in_array($field, $fillable)) {
            echo "✓ Field '$field' in fillable\n";
        } else {
            echo "✗ Field '$field' NOT in fillable\n";
        }
    }
} catch (\Exception $e) {
    echo "✗ Error checking Order model: " . $e->getMessage() . "\n";
}

echo "\n=== All tests completed ===\n";
