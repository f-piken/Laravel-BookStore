<!DOCTYPE html>
<html>
<head>
    <title>Order Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
        }
        table th, table td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 10px;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #ddd;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        a:hover {
            background-color: #0056b3;
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
                <td>{{ $order->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="text-align: center;">
        <a href="{{ route('orders.index') }}">Back</a>
        <a href="{{ route('orders.generate-pdf') }}">Download PDF</a>
    </div>
</body>
</html>
