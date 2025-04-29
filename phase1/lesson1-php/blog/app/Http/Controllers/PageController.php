<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // الصفحة الرئيسية
    public function home()
    {
        $articles = Article::where('is_published', true)
                        ->orderBy('published_at', 'desc')
                        ->paginate(6);

        $categories = Category::withCount('articles')->get();

        return view('pages.home', compact('articles', 'categories'));
    }

    // صفحة من نحن
    public function about()
    {
        return view('pages.about');
    }

    // صفحة اتصل بنا
    public function contact()
    {
        return view('pages.contact');
    }

    // معالجة نموذج الاتصال
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // هنا يمكن إضافة كود لإرسال بريد إلكتروني أو حفظ الرسالة في قاعدة البيانات

        return redirect()->back()->with('success', 'تم إرسال رسالتك بنجاح، سنتواصل معك قريبًا!');
    }
}
