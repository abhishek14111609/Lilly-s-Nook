@php
    $paymentStatus = $order->payment_status ?? 'pending';
    $paymentBadgeClass = match ($paymentStatus) {
        'paid' => 'bg-success',
        'failed' => 'bg-danger',
        default => 'bg-warning text-dark',
    };
    $grandTotal = $order->items->sum(fn($item) => (float) $item->price * $item->quantity);
@endphp

<div class="invoice-panel">
    <div class="invoice-panel-header">
        <div>
            <p class="text-uppercase text-muted small mb-1">Invoice</p>
            <h3 class="mb-1">{{ $order->invoice_number ?? 'INV-' . $order->id }}</h3>
            <p class="text-muted mb-0">
                Order #{{ $order->id }}
                @if ($order->paid_at)
                    · Paid {{ $order->paid_at->format('d M Y h:i A') }}
                @endif
            </p>
        </div>
        <div class="text-md-end">
            <span class="badge {{ $paymentBadgeClass }} mb-2">{{ ucfirst($paymentStatus) }}</span>
            <p class="mb-1 text-muted">Payment method: {{ ucfirst($order->payment_method) }}</p>
            <p class="mb-0 text-muted">Status: {{ ucfirst($order->status) }}</p>
        </div>
    </div>

    <div class="invoice-meta-grid">
        <div class="invoice-meta-card">
            <p class="text-uppercase text-muted small mb-2">Billing details</p>
            <h5 class="mb-2">{{ $order->first_name }} {{ $order->last_name }}</h5>
            <p class="mb-1">{{ $order->email }}</p>
            <p class="mb-1">{{ $order->phone }}</p>
            <p class="mb-0">{{ $order->address }}, {{ $order->city }}, {{ $order->zip }}</p>
        </div>
        <div class="invoice-meta-card">
            <p class="text-uppercase text-muted small mb-2">Payment references</p>
            <p class="mb-1"><strong>Razorpay order:</strong> {{ $order->razorpay_order_id ?? 'N/A' }}</p>
            <p class="mb-1"><strong>Payment ID:</strong> {{ $order->razorpay_payment_id ?? 'N/A' }}</p>
            <p class="mb-0 text-break"><strong>Invoice total:</strong>
                &#8377;{{ number_format((float) $order->total, 2) }}</p>
        </div>
    </div>

    <div class="table-responsive invoice-table-wrap">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Size</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th class="text-end">Line Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->size ?: 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>&#8377;{{ number_format((float) $item->price, 2) }}</td>
                        <td class="text-end">&#8377;{{ number_format((float) $item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total</th>
                    <th class="text-end">&#8377;{{ number_format($grandTotal, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>