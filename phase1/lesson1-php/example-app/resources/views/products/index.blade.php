<html>
<body>
    <h1>المنتجات</h1>

    <ul>
         @foreach($products as $product)
            <li>{{ $product->name }} - {{ $product->price }} $</li>
        @endforeach
    </ul>
</body>
</html>
