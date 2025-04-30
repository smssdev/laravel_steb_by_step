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


// // معامل بسيط
// Route::get('/users/{id}', function ($id) {
//     return 'المستخدم رقم: ' . $id;
// });

// // عدة معاملات
// Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
//     return 'المنشور رقم: ' . $postId . ', التعليق رقم: ' . $commentId;
// });

// Route::get('/users2/{name?}', function ($name = 'زائر') {
//     return 'مرحبا ' . $name;
// });


// // قيد باستخدام تعبير منتظم
// Route::get('/users3/{id}', function ($id) {
//     return 'المستخدم رقم: ' . $id;
// })->where('id', '[0-9]+');

// // // عدة قيود
// Route::get('/posts2/{post}/comments/{comment}', function ($postId, $commentId) {
//     return 'المنشور رقم: ' . $postId . ', التعليق رقم: ' . $commentId;
// })->where([
//     'post' => '[0-9]+',
//     'comment' => '[0-9]+'
// ]);

// // // قيود شائعة
// Route::get('/category/{category}', function ($category) {
//     return 'التصنيف: ' . $category;
// })->whereAlpha('category');  // يقبل فقط الحروف الأبجدية
// Route::get('/category2/{category}', function ($category) {
//     return 'التصنيف: ' . $category;
// })->whereAlphaNumeric('category');  // يقبل فقط الحروف الأبجدية

// Route::get('/products/{id}', function ($id) {
//     return 'المنتج رقم: ' . $id;
// })->whereNumber('id');  // يقبل فقط الأرقام

// Route::get('/profile/{username}', function ($username) {
//     return 'الملف الشخصي: ' . $username;
// })->whereAlphaNumeric('username');  // يقبل الحروف والأرقام


// Route::get('/articles/{slug}', function ($slug) {
//     return 'المقال: ' . $slug;
// })->where('slug', '[A-Za-z0-9_-]+');

// Route::get('/articles2/{slug}', function ($slug) {
//     return 'المقال: ' . $slug;
// })->whereSlug('slug');  // يقبل الحروف والأرقام والشرطات والشرطات السفلية


Route::get('/custom_user/{id}', function ($id) {
    return 'المستخدم رقم: ' . $id;
});


// Route::get('/user/profile', function () {
// })->name('profile');


Route::get('/user/{id}/profile', function ($id) {
    return "PROFILE OK Number " . $id;
})->name('profile');


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return 'لوحة التحكم';
    });
    Route::get('/users', function () {
        return 'إدارة المستخدمين';
    });

    Route::get('/settings', function () {
        return 'الإعدادات';
    });
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return 'لوحة التحكم';
    });

    Route::get('/settings', function () {
        return 'الإعدادات';
    });
});


// Route::namespace('Admin')->group(function () {
//     // المتحكمات ضمن مساحة الأسماء "App\Http\Controllers\Admin"
//     Route::get('/dashboard', [DashboardController::class, 'index']);
// });


Route::name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return 'لوحة التحكم';
    })->name('dashboard');  // اسم المسار سيكون "admin.dashboard"
});


Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return 'لوحة التحكم';
    })->name('dashboard');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', function () {
            return 'قائمة المستخدمين';
        })->name('index');  // اسم المسار: "admin.users.index"

        Route::get('/{id}', function ($id) {
            return 'عرض المستخدم: ' . $id;
        })->name('show');  // اسم المسار: "admin.users.show"
    });
});

// فقط إجراءات محددة
// Route::resource('posts', PostController::class)->only([
//     'index', 'show'
// ]);

// استبعاد إجراءات محددة
// Route::resource('users', UserController::class)->except([
//     'create', 'store', 'edit', 'update', 'destroy'
// ]);


// ===========================================================

# إنشاء متحكم بسيط
// php artisan make:controller UserController

// # إنشاء متحكم للموارد (مع إجراءات CRUD)
// php artisan make:controller ProductController --resource

// # إنشاء متحكم للموارد مع نموذج
// php artisan make:controller PostController --resource --model=Post

// # إنشاء متحكم لواجهة برمجة التطبيقات API
// php artisan make:controller API/CustomerController --api

// # إنشاء متحكم قابل للاستدعاء (Invokable)
// php artisan make:controller ShowDashboard --invokable

// ===========================================================



// استخدام متحكم وطريقة باستخدام مصفوفة
// Route::get('/users', [UserController::class, 'index']);

// استخدام متحكم قابل للاستدعاء
// Route::get('/dashboard', ShowDashboard::class);

// استخدام متحكم موارد
// Route::resource('products', ProductController::class);

// استخدام متحكم موارد API
// Route::apiResource('api/customers', API\CustomerController::class);

// استخدام المتحكم للتعامل مع مجموعة من المسارات
// Route::controller(OrderController::class)->group(function () {
//     Route::get('/orders', 'index');
//     Route::post('/orders', 'store');
//     Route::get('/orders/{id}', 'show');
// });


