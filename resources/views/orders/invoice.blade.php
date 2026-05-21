<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->invoice_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
        }

        .header {
            margin-bottom: 40px;
        }

        .header table {
            width: 100%;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #000;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            text-align: right;
            color: #666;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .info-table td {
            width: 50%;
            vertical-align: top;
        }

        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
            color: #888;
            font-size: 10px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .items-table th {
            background: #f8f9fa;
            border-bottom: 2px solid #eee;
            text-align: left;
            padding: 10px;
            font-size: 11px;
        }

        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .totals-table {
            width: 40%;
            margin-left: 60%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 10px;
        }

        .totals-table .label {
            text-align: right;
            color: #666;
        }

        .totals-table .value {
            text-align: right;
            font-weight: bold;
        }

        .totals-table .grand-total {
            border-top: 2px solid #000;
            font-size: 16px;
            padding-top: 15px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            color: #999;
            font-size: 10px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="header">
            <table>
                <tr>
                    <td><img src="{{ asset('images/logo_lilysnook.png') }}" alt="Lily's Nook"
                            style="height: 50px; width: auto;"></td>
                    <td class="invoice-title">TAX INVOICE</td>
                </tr>
            </table>
        </div>

        <table class="info-table">
            <tr>
                <td>
                    <div class="section-title">Sold By</div>
                    <strong>Lily's Nook Official</strong><br>
                    Lilly's Building, 123 Fashion Street<br>
                    Mumbai, MH, 400001<br>
                    GSTIN: 27ABCDE1234F1Z5<br>
                    Contact: +91 99887 76655
                </td>
                <td style="text-align: right;">
                    <div class="section-title">Order Info</div>
                    Invoice No: <strong>#{{ $order->invoice_number }}</strong><br>
                    Order ID: #{{ $order->id }}<br>
                    Date: {{ $order->ordered_at?->format('d M, Y') }}<br>
                    Status: <span class="badge badge-success">{{ $order->status }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 20px;">
                    <div class="section-title">Billing Address</div>
                    <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                    {{ $order->address }}<br>
                    {{ $order->city }}, {{ $order->zip }}<br>
                    Phone: {{ $order->phone }}<br>
                    Email: {{ $order->email }}
                </td>
                <td style="padding-top: 20px; text-align: right;">
                    <div class="section-title">Shipping Address</div>
                    <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                    {{ $order->address }}<br>
                    {{ $order->city }}, {{ $order->zip }}<br>
                    Phone: {{ $order->phone }}
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th>HSN</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Price</th>
                    <th style="text-align: right;">GST</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->product_name }}</strong><br>
                            <small>Size: {{ $item->size }}</small>
                        </td>
                        <td>{{ $item->product?->hsn_code ?? '6109' }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">₹{{ number_format($item->price, 2) }}</td>
                        <td style="text-align: right;">{{ $item->product?->gst_percentage ?? 18 }}%</td>
                        <td style="text-align: right;">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals-table">
            <tr>
                <td class="label">Subtotal:</td>
                <td class="value">
                    ₹{{ number_format(max(0, $order->total - $order->shipping_fee - $order->tax_amount), 2) }}</td>
            </tr>
            <tr>
                <td class="label">Shipping:</td>
                <td class="value">₹{{ number_format($order->shipping_fee, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Tax (GST):</td>
                <td class="value">₹{{ number_format($order->tax_amount, 2) }}</td>
            </tr>
            <tr class="grand-total">
                <td class="label"><strong>Grand Total:</strong></td>
                <td class="value">
                    <strong>₹{{ number_format($order->total, 2) }}</strong>
                </td>
            </tr>
        </table>

        <div class="footer">
            <p>This is a computer-generated invoice and does not require a physical signature.</p>
            <p>Thank you for shopping with Lily's Nook!</p>
        </div>
    </div>
</body>

</html>
