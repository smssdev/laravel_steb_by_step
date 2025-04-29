<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    // اسم الجدول المرتبط بهذا النموذج (اختياري)
    protected $table = 'articles';
    // الحقول التي يمكن ملؤها
    protected $fillable = [
        'title', 'content', 'author_id', 'published_at'
    ];
    // العلاقة مع نموذج الكاتب (User)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    // العلاقة مع نموذج التعليقات (Comment)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // عرض صفحة إنشاء مقال جديد
    public function create()
    {
        return view('articles.create');
    }

    // حفظ مقال جديد
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $article = Article::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'author_id' => auth()->id(),
            'published_at' => now(),
        ]);

        return redirect()->route('articles.show', $article->id)
            ->with('success', 'تم إنشاء المقال بنجاح!');
    }



}
