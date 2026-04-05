<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    protected $fillable = ['product_id', 'user_id', 'body'];

    // Each comment belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Each comment belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
