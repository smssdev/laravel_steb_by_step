<?php
// app/Models/Comment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'content', 'user_id', 'article_id'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
