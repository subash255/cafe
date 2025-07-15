<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order #{{ $order->id }} - Print Receipt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .order-info {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        
        .customer-info, .delivery-info {
            margin: 20px 0;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .items-table th,
        .items-table td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
        }
        
        .items-table th {
            background: #f8f9fa;
            font-weight: bold;
        }
        
        .total-section {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #333;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        
        .total-amount {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            color: #666;
        }
        
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Cafe Management System</div>
        <div>Order Receipt</div>
        <div>Date: {{ $order->created_at->format('M j, Y \a\t g:i A') }}</div>
    </div>

    <div class="order-info">
        <h3 style="margin: 0 0 10px 0;">Order Information</h3>
        <div><strong>Order ID:</strong> #{{ $order->id }}</div>
        <div><strong>Order Date:</strong> {{ $order->created_at->format('M j, Y \a\t g:i A') }}</div>
        <div><strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</div>
        <div><strong>Payment Method:</strong> 
            @if($order->payment_method === 'esewa')
                eSewa
            @else
                Cash on Delivery
            @endif
        </div>
        <div><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</div>
        @if($order->payment_reference)
        <div><strong>Payment Reference:</strong> {{ $order->payment_reference }}</div>
        @endif
    </div>

    <div class="customer-info">
        <h3>Customer Information</h3>
        <div><strong>Name:</strong> {{ $order->user->name ?? 'Guest' }}</div>
        <div><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</div>
        <div><strong>Phone:</strong> {{ $order->phone_number }}</div>
    </div>

    <div class="delivery-info">
        <h3>Delivery Information</h3>
        <div><strong>Address:</strong> {{ $order->delivery_address }}</div>
        @if($order->notes)
        <div><strong>Special Instructions:</strong> {{ $order->notes }}</div>
        @endif
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->fooditem->name ?? 'Unknown Item' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rs. {{ number_format($item->price, 2) }}</td>
                <td>Rs. {{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>Rs. {{ number_format($order->orderItems->sum('total'), 2) }}</span>
        </div>
        <div class="total-row">
            <span>Tax & Fees:</span>
            <span>Rs. {{ number_format($order->total_amount - $order->orderItems->sum('total'), 2) }}</span>
        </div>
        <div class="total-row total-amount">
            <span>Total Amount:</span>
            <span>Rs. {{ number_format($order->total_amount, 2) }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for your order!</p>
        <p>For any questions, please contact us at support@cafe.com</p>
        <p>Printed on {{ now()->format('M j, Y \a\t g:i A') }}</p>
    </div>

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #2563eb; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Print Receipt
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #6b7280; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            Close
        </button>
    </div>

    <script>
        // Auto-print when page loads
        window.addEventListener('load', function() {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
