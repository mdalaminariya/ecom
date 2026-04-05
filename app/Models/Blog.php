<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $guarded = [];
     public function category(){
        return $this->hasOne(Category::class, 'id','category_id');
    }
    public function user(){
        return $this->hasOne(User::class, 'id','user_id');
    }
    public function blog_comment(){
        return $this->hasMany(BlogComment::class, 'blog_id','id');
    }
}
