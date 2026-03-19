<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $categories = Category::where('status', 'active')->latest()->paginate(6);
        $products = Product::where('status', 'active')->latest()->get();
        $bestProducts = Product::where('status', 'active') ->where('is_best_seller', 1)->latest()->take(10)->get();
        return view('frontend.home.home', compact('categories', 'products', 'bestProducts'));
    }
}
