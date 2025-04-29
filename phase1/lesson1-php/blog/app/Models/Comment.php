<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'is_approved',
        'user_id',
        'article_id',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    // العلاقة مع المستخدم: التعليق ينتمي إلى مستخدم واحد
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع المقال: التعليق ينتمي إلى مقال واحد
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
