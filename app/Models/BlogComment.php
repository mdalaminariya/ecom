<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'user_id',
        'name',
        'email',
        'message',
        'parent_id',
    ];

    // User who wrote the comment
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Replies (direct children)
    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id');
    }

    // Recursive relationship for nested replies
    public function repliesRecursive()
    {
        return $this->replies()->with('repliesRecursive');
    }

    // Blog that this comment belongs to
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
