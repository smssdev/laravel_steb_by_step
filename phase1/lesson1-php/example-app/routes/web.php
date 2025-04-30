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


// معامل بسيط
Route::get('/users/{id}', function ($id) {
    return 'المستخدم رقم: ' . $id;
});

// عدة معاملات
Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'المنشور رقم: ' . $postId . ', التعليق رقم: ' . $commentId;
});

Route::get('/users2/{name?}', function ($name = 'زائر') {
    return 'مرحبا ' . $name;
});


// قيد باستخدام تعبير منتظم
Route::get('/users3/{id}', function ($id) {
    return 'المستخدم رقم: ' . $id;
})->where('id', '[0-9]+');

// // عدة قيود
Route::get('/posts2/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'المنشور رقم: ' . $postId . ', التعليق رقم: ' . $commentId;
})->where([
    'post' => '[0-9]+',
    'comment' => '[0-9]+'
]);

// // قيود شائعة
Route::get('/category/{category}', function ($category) {
    return 'التصنيف: ' . $category;
})->whereAlpha('category');  // يقبل فقط الحروف الأبجدية
Route::get('/category2/{category}', function ($category) {
    return 'التصنيف: ' . $category;
})->whereAlphaNumeric('category');  // يقبل فقط الحروف الأبجدية

Route::get('/products/{id}', function ($id) {
    return 'المنتج رقم: ' . $id;
})->whereNumber('id');  // يقبل فقط الأرقام

Route::get('/profile/{username}', function ($username) {
    return 'الملف الشخصي: ' . $username;
})->whereAlphaNumeric('username');  // يقبل الحروف والأرقام


Route::get('/articles/{slug}', function ($slug) {
    return 'المقال: ' . $slug;
})->where('slug', '[A-Za-z0-9_-]+');

Route::get('/articles2/{slug}', function ($slug) {
    return 'المقال: ' . $slug;
})->whereSlug('slug');  // يقبل الحروف والأرقام والشرطات والشرطات السفلية
