@extends('layouts.admin')
@section('title', 'Admin Order #' . $order->id)

@push('styles')
    <style>
        .order-detail-shell {
            display: grid;
            gap: 1.5rem;
        }

        .order-detail-hero {
            background:
                linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(255, 246, 248, 0.98)),
                radial-gradient(circle at top right, rgba(244, 143, 177, 0.12), transparent 28%),
                radial-gradient(circle at bottom left, rgba(15, 23, 42, 0.04), transparent 22%);
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 1.5rem;
            padding: 1.5rem;
            box-shadow: 0 0.75rem 2rem rgba(15, 23, 42, 0.06);
        }

        .order-heading-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            margin-top: 0.75rem;
        }

        .order-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 0.42rem 0.8rem;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border: 1px solid transparent;
        }

        .order-badge--status {
            background: #f8fafc;
            color: #334155;
            border-color: rgba(148, 163, 184, 0.3);
        }

        .order-badge--payment {
            background: rgba(34, 197, 94, 0.12);
            color: #166534;
            border-color: rgba(34, 197, 94, 0.2);
        }

        .order-badge--invoice {
            background: rgba(59, 130, 246, 0.12);
            color: #1d4ed8;
            border-color: rgba(59, 130, 246, 0.2);
        }

        .order-meta-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-top: 1.25rem;
        }

        .order-meta-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 1rem;
            padding: 1rem 1.1rem;
            box-shadow: 0 0.5rem 1.4rem rgba(15, 23, 42, 0.04);
        }

        .order-meta-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 0.35rem;
        }

        .order-meta-value {
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
            word-break: break-word;
        }

        .admin-order-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.65fr) minmax(340px, 0.95fr);
            gap: 1.5rem;
            align-items: start;
        }

        .order-stack {
            display: grid;
            gap: 1.25rem;
        }

        .order-card {
            overflow: hidden;
            border-radius: 1.25rem;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 0.75rem 1.6rem rgba(15, 23, 42, 0.05);
        }

        .order-card .admin-surface-header {
            padding: 1rem 1.25rem;
            background: linear-gradient(180deg, #ffffff 0%, #fbfbfc 100%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .order-card .admin-surface-body {
            padding: 1.25rem;
        }

        .order-section-title {
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            margin-bottom: 0;
        }

        .order-items-table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .order-items-table tbody td,
        .order-items-table tfoot th {
            vertical-align: middle;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .order-items-empty {
            padding: 1.5rem;
            text-align: center;
            color: #6b7280;
            background: #fafafa;
        }

        .order-summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 0.7rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .order-summary-row:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .order-summary-label {
            color: #6b7280;
            font-weight: 600;
        }

        .order-summary-value {
            color: #111827;
            font-weight: 700;
            text-align: right;
            word-break: break-word;
        }

        .order-customer-block {
            display: grid;
            gap: 0.75rem;
        }

        .order-address-box {
            padding: 0.95rem 1rem;
            border-radius: 1rem;
            background: #fafafa;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .order-address-box .order-summary-value {
            text-align: left;
            font-weight: 600;
        }

        @media (max-width: 1199.98px) {
            .order-meta-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .admin-order-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 575.98px) {
            .order-meta-grid {
                grid-template-columns: 1fr;
            }

            .order-detail-hero {
                padding: 1.1rem;
            }

            .order-card .admin-surface-body,
            .order-card .admin-surface-header {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $statusBadgeClass = match ($order->status) {
            'delivered' => 'bg-success-subtle text-success border border-success-subtle',
            'shipped' => 'bg-primary-subtle text-primary border border-primary-subtle',
            'processing' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
            'canceled' => 'bg-danger-subtle text-danger border border-danger-subtle',
            default => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
        };

        $paymentBadgeClass =
            $order->payment_status === 'paid'
                ? 'bg-success-subtle text-success border border-success-subtle'
                : 'bg-warning-subtle text-warning-emphasis border border-warning-subtle';
    @endphp

    <div class="page-header">
        <div class="order-detail-hero">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div class="pe-xl-4">
                    <p class="text-uppercase text-muted small mb-1 fw-semibold">Order details</p>
                    <h1 class="h3 mb-2">Order #{{ $order->id }}</h1>
                    <p class="text-muted mb-0">Placed on {{ $order->ordered_at->format('M d, Y') }}. Invoice
                        {{ $order->invoice_number ?? 'Pending' }}.</p>
                    <div class="order-heading-actions">
                        <span
                            class="order-badge order-badge--status {{ $statusBadgeClass }}">{{ ucfirst($order->status) }}</span>
                        <span
                            class="order-badge order-badge--payment {{ $paymentBadgeClass }}">{{ ucfirst($order->payment_status ?? 'pending') }}</span>
                        <span
                            class="order-badge order-badge--invoice">{{ $order->invoice_number ?? 'Invoice pending' }}</span>
                    </div>
                </div>

                <div class="admin-inline-actions">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark px-4">Back to Orders</a>
                </div>
            </div>

            <div class="order-meta-grid">
                <div class="order-meta-card">
                    <span class="order-meta-label">Order Total</span>
                    <p class="order-meta-value">&#8377;{{ number_format((float) ($order->total ?? 0), 2) }}</p>
                </div>
                <div class="order-meta-card">
                    <span class="order-meta-label">Payment Method</span>
                    <p class="order-meta-value">{{ ucfirst($order->payment_method) }}</p>
                </div>
                <div class="order-meta-card">
                    <span class="order-meta-label">Paid At</span>
                    <p class="order-meta-value">{{ $order->paid_at?->format('M d, Y h:i A') ?? 'Pending' }}</p>
                </div>
                <div class="order-meta-card">
                    <span class="order-meta-label">Customer</span>
                    <p class="order-meta-value">{{ $order->first_name }} {{ $order->last_name }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-order-grid order-detail-shell">
        <div class="order-stack">
            <div class="admin-surface order-card">
                <div class="admin-surface-header">
                    <h5 class="order-section-title">Items</h5>
                </div>
                <div class="admin-surface-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 order-items-table align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-4">Item</th>
                                    <th>Size</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th class="pe-4 text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order->items as $item)
                                    <tr>
                                        <td class="ps-4 fw-semibold">{{ $item->product_name }}</td>
                                        <td>{{ $item->size ?: 'N/A' }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $item->quantity }}</span></td>
                                        <td>&#8377;{{ number_format($item->price, 2) }}</td>
                                        <td class="pe-4 text-end fw-semibold">
                                            &#8377;{{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="order-items-empty">No line items found for this order.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end ps-4">Grand Total</th>
                                    <th class="pe-4 text-end">&#8377;{{ number_format((float) ($order->total ?? 0), 2) }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="admin-surface order-card">
                <div class="admin-surface-header">
                    <h5 class="order-section-title">Status Update</h5>
                </div>
                <div class="admin-surface-body">
                    <form action="{{ route('admin.orders.update', $order) }}" method="post" class="vstack gap-3">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="form-label fw-semibold">Current Status</label>
                            <select name="status" class="form-select">
                                <option value="placed" @selected($order->status == 'placed')>Placed</option>
                                <option value="processing" @selected($order->status == 'processing')>Processing</option>
                                <option value="shipped" @selected($order->status == 'shipped')>Shipped</option>
                                <option value="delivered" @selected($order->status == 'delivered')>Delivered</option>
                                <option value="canceled" @selected($order->status == 'canceled')>Canceled</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label fw-semibold">AWB Number</label>
                            <input type="text" name="awb_number" class="form-control" value="{{ $order->awb_number }}"
                                placeholder="Tracking Number">
                        </div>
                        <div>
                            <label class="form-label fw-semibold">Courier Name</label>
                            <input type="text" name="courier_name" class="form-control"
                                value="{{ $order->courier_name }}" placeholder="e.g. Delhivery, BlueDart">
                        </div>
                        <button type="submit" class="btn btn-dark btn-lg w-100">Update Order</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="order-stack">
            <div class="admin-surface order-card">
                <div class="admin-surface-header">
                    <h5 class="order-section-title">Payment Information</h5>
                </div>
                <div class="admin-surface-body">
                    <div class="order-summary-row">
                        <span class="order-summary-label">Method</span>
                        <span class="order-summary-value">{{ ucfirst($order->payment_method) }}</span>
                    </div>
                    <div class="order-summary-row">
                        <span class="order-summary-label">Status</span>
                        <span class="order-summary-value">{{ ucfirst($order->payment_status ?? 'pending') }}</span>
                    </div>
                    <div class="order-summary-row">
                        <span class="order-summary-label">Paid at</span>
                        <span
                            class="order-summary-value">{{ $order->paid_at?->format('M d, Y h:i A') ?? 'Pending' }}</span>
                    </div>
                    <div class="order-summary-row">
                        <span class="order-summary-label">Razorpay payment ID</span>
                        <span class="order-summary-value">{{ $order->razorpay_payment_id ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="admin-surface order-card">
                <div class="admin-surface-header">
                    <h5 class="order-section-title">Customer Information</h5>
                </div>
                <div class="admin-surface-body">
                    <div class="order-customer-block">
                        <div class="order-summary-row">
                            <span class="order-summary-label">Name</span>
                            <span class="order-summary-value">{{ $order->first_name }} {{ $order->last_name }}</span>
                        </div>
                        <div class="order-summary-row">
                            <span class="order-summary-label">Email</span>
                            <span class="order-summary-value">{{ $order->email }}</span>
                        </div>
                        <div class="order-summary-row">
                            <span class="order-summary-label">Phone</span>
                            <span class="order-summary-value">{{ $order->phone }}</span>
                        </div>
                        <div class="order-address-box">
                            <div class="order-summary-row align-items-start border-0 p-0 mb-0">
                                <span class="order-summary-label">Shipping Address</span>
                                <span class="order-summary-value">{{ $order->address }}<br>{{ $order->city }},
                                    {{ $order->zip }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
