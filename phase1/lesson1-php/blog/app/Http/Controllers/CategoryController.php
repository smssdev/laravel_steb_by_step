<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        // تطبيق وسيط المصادقة على جميع الطرق باستثناء index و show
        $this->middleware('auth')->except(['index', 'show']);
        // تطبيق وسيط للتحقق من الصلاحيات الإدارية
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * عرض قائمة الفئات
     */
    public function index()
    {
        $categories = Category::withCount('articles')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * عرض نموذج إنشاء فئة جديدة
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * حفظ فئة جديدة في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        $category = Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
        ]);

        return redirect()->route('categories.show', $category)
            ->with('success', 'تم إنشاء الفئة بنجاح!');
    }

    /**
     * عرض فئة محددة
     */
    public function show(Category $category)
    {
        $articles = $category->articles()
                           ->where('is_published', true)
                           ->orderBy('published_at', 'desc')
                           ->paginate(10);

        return view('categories.show', compact('category', 'articles'));
    }

    /**
     * عرض نموذج تعديل فئة
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * تحديث فئة محددة في قاعدة البيانات
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
        ]);

        return redirect()->route('categories.show', $category)
            ->with('success', 'تم تحديث الفئة بنجاح!');
    }

    /**
     * حذف فئة محددة من قاعدة البيانات
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'تم حذف الفئة بنجاح!');
    }
}
