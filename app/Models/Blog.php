<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $guarded = []; // You can also use $fillable for security

    // Relationship: Blog belongs to a Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // Relationship: Blog belongs to a User (author)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relationship: Blog has many Comments
    public function blog_comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_id', 'id')
                    ->whereNull('parent_id') // only top-level comments
                    ->latest();
    }
}
