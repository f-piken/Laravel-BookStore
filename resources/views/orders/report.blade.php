<!DOCTYPE html>
<html>
<head>
    <title>Order Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            background-color: #fff;
            font-size: 12px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            text-align: center;
            padding: 10px;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        @media print {
            body {
                margin: 0;
                background-color: #fff;
                color: #000;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <h1>Order Report WijayaBook</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Order Number</th>
                <th>Seller</th>
                <th>Customer</th>
                <th>Delivery Option</th>
                <th>Subtotal</th>
                <th>Tax</th>
                <th>Total</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->seller->user->name }}</td>
                <td>{{ $order->customer->user->name }}</td>
                <td>{{ $order->deliveryOption->name }}</td>
                <td>{{ number_format($order->subtotal, 2) }}</td>
                <td>{{ number_format($order->tax, 2) }}</td>
                <td>{{ number_format($order->total_amount, 2) }}</td>
                <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Generated on {{ now()->format('d-m-Y H:i') }}</p>
    </div>
</body>
</html>
