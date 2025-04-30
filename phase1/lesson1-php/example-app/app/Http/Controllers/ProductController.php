<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Request;

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
