<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Weekly Product Updates</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #696cff;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            border-radius: 5px 5px 0 0;
        }

        .product {
            border-bottom: 1px solid #ccc;
            padding: 10px;
        }

        .product a {
            color: #696cff;
            text-decoration: none;
        }

        .product a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Weekly Product Updates</h1>
        </div>
        <div class="content">
            @foreach ($products as $product)
                <div class="product">
                    <h2><a href="{{ route('products-details.show',['product'=>$product->id]) }}">{{ $product->name }}</a></h2>
                    <p>{{ $product->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
