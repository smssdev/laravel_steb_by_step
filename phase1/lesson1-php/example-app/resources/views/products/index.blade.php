<html>
<body>
    <h1>المنتجات</h1>
    <a href="{{ route('profile') }}">الملف الشخصي</a>

    <ul>
         @foreach($products as $product)
            <li>{{ $product->name }} - {{ $product->price }} $</li>
        @endforeach
    </ul>
</body>
</html>
