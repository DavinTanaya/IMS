<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .container {
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            box-sizing: border-box;
        }
        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .header img {
            width: 150px;
            height: auto;
            display: table-cell;
            vertical-align: top;
            padding-top: 10px;
        }
        .header-info, .header-date {
            display: table-cell;
            vertical-align: top;
        }
        .header-info {
            width: calc(100% - 200px);
            text-align: center;
        }
        .header-info h1 {
            margin: 0;
        }
        .header-date {
            width: 200px;
            text-align: right;
            padding-top: 20px;
        }
        .content {
            margin-top: 20px;
        }
        .content .address {
            display: table;
            width: 100%;
        }
        .content .address .column {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            padding: 10px;
        }
        .content .address .column.ship-to {
            width: 20%;
            padding-left: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .table img {
            max-width: 100px;
            max-height: 100px;
        }
        .address{
            overflow-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $logo }}" alt="Logo">
            <div class="header-info">
                <h1>Invoice #1002</h1>
            </div>
            <div class="header-date">
                <p>{{ $order->formatted_date }}</p>
                <p>{{ $order->formatted_hour }}</p>
            </div>
        </div>
        <div class="content">
            <div class="address">
                <div class="column">
                    <h2>Bill To</h2>
                    <p>{{ $order->user->name }}</p>
                    <p>{{ $order->user->email }}</p>
                    <p>{{ $order->user->phone_number }}</p>
                </div>
                <div class="column ship-to">
                    <h2>Ship To</h2>
                    <p>{{ $order->user->name }}</p>
                    <p>{{ $order->user->email }}</p>
                    <p>{{ $order->user->phone_number }}</p>
                    <p id="address">{{ $order->address . ', ' . $city->name . ', ' . $order->province->name }}</p>
                    <p>{{ $order->zip_code }}</p>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->order_products as $order_products)
                        <tr>
                            <td>
                                <p>{{ $order_products->product->name }}</p>
                                <p style="color: #6b7280; font-size: 0.75rem">Category: {{ $order_products->product->category->name }}</p>
                            </td>
                            <td><img src="{{ $order_products->product->image_base64 }}" alt="Product Image"></td>
                            <td>{{ $order_products->quantity }}</td>
                            <td>Rp. {{ number_format($order_products->product->price, 0, ',', '.') }},00</td>
                            <td>Rp. {{ number_format($order_products->total, 0, ',', '.') }},00</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-bold" style="border:none;">
                        <td colspan="3" style="border:none;"></td>
                        <td style="font-size: 18px; line-height: 28px; border: solid 1px #e5e7eb; background-color:#f8f9fa; color:red; font-weight:bold;">Total</td>
                        <td style="border: solid 1px #e5e7eb; color:red; background-color:#f8f9fa; font-weight:bold;">Rp. {{ number_format($order->order_products->sum('total'), 0, ',', '.') }},00</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>
