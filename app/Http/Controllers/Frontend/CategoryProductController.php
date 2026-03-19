<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Newsletter;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    public function index($slug){
    $category = Category::where('slug', $slug)->first();
    $cats = Category::where('status', 'active')->latest()->get();
    $products = Product::where('category_id',$category->id)->latest()->paginate(10);
    $producs = Product::where('status','active')->latest()->take(6)->get();
            $subscribed = false;

        if(session()->has('newsletter_email')){
            $subscribed = Newsletter::where('email', session('newsletter_email'))->exists();
        }
    return view('frontend.categoryproduct.index',compact('category','products','cats','producs','subscribed'));
    }
   public function search(Request $request)
    {
        $search = $request->input('search');

        $products = Product::when($search, function($query, $search) {
                        $query->where(function($q) use ($search) {
                            $q->where('title', 'LIKE', "%{$search}%")
                              ->orWhere('short_description', 'LIKE', "%{$search}%");
                        });
                    })
                    ->latest()
                    ->paginate(10)
                    ->withQueryString();

        $cats = Category::where('status','active')->latest()->get();

        return view('frontend.search.index', compact('products','cats','search'));
    }
}
