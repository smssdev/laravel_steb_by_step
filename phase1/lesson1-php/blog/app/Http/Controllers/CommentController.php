<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * إضافة تعليق جديد
     */
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        $article->comments()->save($comment);

        return redirect()->back()->with('success', 'تم إضافة التعليق بنجاح!');
    }

    /**
     * حذف تعليق
     */
    public function destroy(Comment $comment)
    {
        // التحقق من أن المستخدم هو صاحب التعليق أو مؤلف المقال أو مدير
        if (auth()->id() !== $comment->user_id &&
            auth()->id() !== $comment->article->user_id &&
            !optional(auth()->user())->isAdmin()) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'تم حذف التعليق بنجاح!');
    }

    /**
     * تغيير حالة اعتماد التعليق (للمدراء ومؤلفي المقالات)
     */
    public function toggleApproval(Comment $comment)
    {
        // التحقق من أن المستخدم هو مؤلف المقال أو مدير
        if (auth()->id() !== $comment->article->user_id && !optional(auth()->user())->isAdmin()) {
            abort(403);
        }

        $comment->update([
            'is_approved' => !$comment->is_approved,
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة التعليق بنجاح!');
    }
}
