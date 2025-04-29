<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

     // العلاقة مع المقالات: الفئة لديها العديد من المقالات
     public function articles()
     {
         return $this->hasMany(Article::class);
     }

     // دالة لإنشاء slug تلقائيًا من الاسم
     protected static function booted()
     {
         static::creating(function ($category) {
             $category->slug = Str::slug($category->name);
         });

         static::updating(function ($category) {
             $category->slug = Str::slug($category->name);
         });
     }
}
