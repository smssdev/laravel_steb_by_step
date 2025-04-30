<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index']);
// Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index']);
Route::get('/tasks', [TaskController::class, 'index']);

Route::any('/any', function () {
    return 'هذا المسار يستجيب لجميع طرق HTTP';
});

// الاستجابة لعدة طرق
Route::match(['get', 'post'], '/match', function () {
    return 'هذا المسار يستجيب لطلبات GET و POST';
});

// يجب أن يكون هذا المسار دائماً في نهاية ملف routes/web.php
Route::fallback(function () {
    // // يمكنك هنا إرجاع عرض مخصص
    // return view('error404');

    // // أو إرجاع استجابة مخصصة
    return response()->view('error404', [], 404);
    // أو ببساطة إرجاع رسالة
    // return 'المسار المطلوب غير موجود!';
});
