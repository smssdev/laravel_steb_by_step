<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'مرحباً بك في Laravel!';
});

Route::get('/about_simple', function () {
    return 'اسمي: سليمان<br>عمري: 32 سنة<br>هواياتي: البرمجة، القراءة، الرياضة';
});

Route::get('/about', function () {
    $name= "Solayman";
    $age= "32";
    $hobbies= ['Football', 'Reading', 'WatchingFilms'];
    // $data=[
    // 'name'=> $name,
    // 'age'=> $age,
    // 'hobbies' => $hobbies
    // ];
    // return $data;
    // return view('about', $data);
    return view('about', compact('name', 'age', 'hobbies'));
});

Route::get('/calculator/{num1}/{num2}', function ($num1,$num2) {
    $sum= $num1 + $num2;
    // return "مجموع ${num1} و  ${num2} هو : ${sum} ";
    return "$num1 + $num2 = $sum";
});
