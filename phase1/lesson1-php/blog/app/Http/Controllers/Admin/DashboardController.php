<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * عرض لوحة التحكم الرئيسية
     */
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'articles' => Article::count(),
            'published_articles' => Article::where('is_published', true)->count(),
            'categories' => Category::count(),
            'comments' => Comment::count(),
            'pending_comments' => Comment::where('is_approved', false)->count(),
        ];

        $latestArticles = Article::with('user')
                               ->latest()
                               ->take(5)
                               ->get();

        $latestComments = Comment::with(['user', 'article'])
                               ->latest()
                               ->take(5)
                               ->get();

        return view('admin.dashboard', compact('stats', 'latestArticles', 'latestComments'));
    }

    /**
     * عرض جميع المستخدمين
     */
    public function users()
    {
        $users = User::withCount(['articles', 'comments'])
                   ->paginate(15);

        return view('admin.users', compact('users'));
    }

    /**
     * تغيير حالة المستخدم (مدير/مستخدم عادي)
     */
    public function toggleAdmin(User $user)
    {
        // التأكد من أن المستخدم لا يحاول إزالة حقوق المدير عن نفسه
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'لا يمكنك تغيير حالة حسابك الخاص!');
        }

        $user->update([
            'is_admin' => !$user->is_admin,
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة المستخدم بنجاح!');
    }

    /**
     * عرض جميع المقالات
     */
    public function articles()
    {
        $articles = Article::with(['user', 'category'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);

        return view('admin.articles', compact('articles'));
    }

    /**
     * عرض جميع التعليقات
     */
    public function comments()
    {
        $comments = Comment::with(['user', 'article'])
                         ->orderBy('created_at', 'desc')
                         ->paginate(15);

        return view('admin.comments', compact('comments'));
    }
}
