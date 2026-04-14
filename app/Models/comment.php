<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Allow all fields to be mass assignable
    protected $guarded = [];

    // Replies relationship
     public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Optional: relation to product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
