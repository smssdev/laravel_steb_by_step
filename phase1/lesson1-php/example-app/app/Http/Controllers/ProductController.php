<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        // إنشاء رابط
        // $url = route('profile');
        // return redirect()->route('profile');
        return view('products.index', compact('products'));
    }
}
