<?php
// app/Http/Controllers/ArticleController.php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')
            ->latest()
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'in:draft,published,archived'
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('articles', 'public');
        }

        $article = Article::create($validated);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article created successfully');
    }

    public function show(Article $article)
    {
        $article->load('author', 'comments.author');
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'in:draft,published,archived'
        ]);

        if ($request->hasFile('featured_image')) {
            // حذف الصورة القديمة إن وجدت
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }

            $validated['featured_image'] = $request->file('featured_image')
                ->store('articles', 'public');
        }

        $article->update($validated);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article updated successfully');
    }

    public function destroy(Article $article)
    {
        // حذف الصورة المرتبطة
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article deleted successfully');
    }
}
