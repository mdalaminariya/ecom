<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [''];

   public function getFormattedPriceAttribute()
{
    return number_format($this->price, 0);
}
    public function category(){
        return $this->hasOne(Category::class, 'id','category_id');
    }
    public function user(){
        return $this->hasOne(User::class, 'id','user_id');
    }
    public function carts(){
    return $this->hasMany(Cart::class);
}
}
