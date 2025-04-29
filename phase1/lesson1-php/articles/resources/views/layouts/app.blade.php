<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'مدونتي') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('articles.index') }}" class="text-2xl font-bold text-blue-600">مدونتي</a>

            <div class="space-x-4 rtl:space-x-reverse">
                @guest
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">تسجيل الدخول</a>
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">التسجيل</a>
                @else
                    <a href="{{ route('articles.create') }}" class="text-green-600 hover:text-green-800">إنشاء مقال</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">تسجيل الخروج</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-6 px-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white shadow-md mt-6 py-4">
        <div class="container mx-auto text-center">
            <p>&copy; {{ date('Y') }} مدونتي. جميع الحقوق محفوظة.</p>
        </div>
    </footer>
</body>
</html>
