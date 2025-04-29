<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // عرض قائمة المقالات
    public function index()
    {
        $articles = Article::with('author')->latest()->paginate(10);

        return view('articles.index', compact('articles'));
    }

      // عرض مقال محدد
      public function show($id)
      {
          $article = Article::with(['author', 'comments.user'])->findOrFail($id);

          return view('articles.show', compact('article'));
      }

}
