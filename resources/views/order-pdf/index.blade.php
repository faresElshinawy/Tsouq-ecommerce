<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tsouq Invoice</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Header Styles */
        .header {
            background-color: #232f3e;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        /* Invoice Container */
        .invoice-container {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Invoice Details */
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        /* Left Section */
        .invoice-details-left {
            width: 48%; /* Adjust the width as needed */
        }

        /* Right Section */
        .invoice-details-right {
            width: 48%; /* Adjust the width as needed */
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #232f3e;
            color: #fff;
        }

        /* Footer Styles */
        .footer {
            text-align: center;
            margin-top: 20px;
        }

        /* Product Row Styles */
        .product-row {
            background-color: #f9f9f9;
        }

        /* Total Section Styles */
        .total-section {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: right;
        }

        .total-label {
            font-weight: bold;
        }

        .total-value {
            font-size: 18px;
            color: #e47911;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Tsouq Invoice</h1>
    </div>
    <div class="invoice-container">
        <div class="invoice-details">
            <div class="invoice-details-left">
                <p><strong>Username:</strong> {{ $order->user->name }}</p>
                <p><strong>User Email:</strong> {{ $order->user->email }}</p>
                @if ($order->address ?? false)
                    <p><strong>User Phone:</strong> {{ $address->phone }}</p>
                    <p><strong>Order Address To:</strong> {{ $address->country->name . ', ' . ($address->city_spare) . ', ' . $address->street . ', ' . $address->building_number }}</p>
                @endif
            </div>
            <div class="invoice-details-right">
                <p><strong>Products Count:</strong> {{ $orderitems->count() }}</p>
                <p><strong>Order Status:</strong> {{ str_replace('_', ' ', $order->status) }}</p>
                <p><strong>Order Serial Number:</strong> {{ $order->order_serial_code }}</p>
                <p><strong>Total Price:</strong> <span class="total-value">${{ $order->total_price }}</span></p>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Discount</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderitems as $item)
                    <tr class="product-row">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>${{ $item->price }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->discount }}%</td>
                        <td>${{ $item->final_price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total-section">
            <p class="total-label">Grand Total:</p>
            <p class="total-value">${{ $order->total_price }}</p>
        </div>
    </div>
</body>
</html>
