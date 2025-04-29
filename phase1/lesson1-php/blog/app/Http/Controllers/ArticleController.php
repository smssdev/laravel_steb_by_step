<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function __construct()
    {
        // تطبيق وسيط المصادقة على جميع الطرق باستثناء index و show
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * عرض قائمة المقالات
     */
    public function index()
    {
        $articles = Article::with(['user', 'category'])
                        ->where('is_published', true)
                        ->orderBy('published_at', 'desc')
                        ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    /**
     * عرض نموذج إنشاء مقال جديد
     */
    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    /**
     * حفظ مقال جديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        // معالجة الصورة إذا تم تحميلها
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('articles', 'public');
        }

        $article = Article::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'is_published' => $request->has('is_published'),
            'published_at' => $request->has('is_published') ? now() : null,
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
        ]);

        return redirect()->route('articles.show', $article)
            ->with('success', 'تم إنشاء المقال بنجاح!');
    }

    /**
     * عرض مقال محدد
     */
    public function show(Article $article)
    {
        // التحقق من أن المقال منشور أو أن المستخدم هو المؤلف أو مدير
        if (!$article->is_published && auth()->id() !== $article->user_id && !optional(auth()->user())->isAdmin()) {
            abort(404);
        }

        $article->load(['user', 'category', 'comments.user']);

        return view('articles.show', compact('article'));
    }

    /**
     * عرض نموذج تعديل مقال
     */
    public function edit(Article $article)
    {
        // التحقق من أن المستخدم هو المؤلف أو مدير
        if (auth()->id() !== $article->user_id && !optional(auth()->user())->isAdmin()) {
            abort(403);
        }

        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    /**
     * تحديث مقال محدد في قاعدة البيانات
     */
    public function update(Request $request, Article $article)
    {
        // التحقق من أن المستخدم هو المؤلف أو مدير
        if (auth()->id() !== $article->user_id && !optional(auth()->user())->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        // معالجة الصورة إذا تم تحميلها
        if ($request->hasFile('featured_image')) {
            // حذف الصورة القديمة إذا وجدت
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $imagePath = $request->file('featured_image')->store('articles', 'public');
        } else {
            $imagePath = $article->featured_image;
        }

        // تحديث حالة النشر وتاريخ النشر
        $isNowPublished = $request->has('is_published') && !$article->is_published;
        $publishedAt = $article->published_at;
        if ($isNowPublished) {
            $publishedAt = now();
        } elseif (!$request->has('is_published')) {
            $publishedAt = null;
        }

        $article->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'is_published' => $request->has('is_published'),
            'published_at' => $publishedAt,
            'category_id' => $validated['category_id'],
        ]);

        return redirect()->route('articles.show', $article)
            ->with('success', 'تم تحديث المقال بنجاح!');
    }

    /**
     * حذف مقال محدد من قاعدة البيانات
     */
    public function destroy(Article $article)
    {
        // التحقق من أن المستخدم هو المؤلف أو مدير
        if (auth()->id() !== $article->user_id && !optional(auth()->user())->isAdmin()) {
            abort(403);
        }

        // حذف الصورة إذا وجدت
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'تم حذف المقال بنجاح!');
    }
}
