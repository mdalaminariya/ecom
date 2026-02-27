<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('dashboard.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status',"active")->latest()->get();
        return view('dashboard.product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $manager = new ImageManager(new Driver());
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'price' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'thumbnail' => 'required|image',
        ]);

        if($request->hasFile('thumbnail')){
            $newname = auth()->user()->id.'-'.Str::random(4).'.'.$request->file('thumbnail')->getClientOriginalExtension();
            $image = $manager->read($request->file('thumbnail'));
            $image->toPng()->save(base_path('public/images/product/'.$newname));

            if($request->slug){
                Product::create([
                    'user_id' => auth()->user()->id,
                    'category_id' => $request->category_id,
                    'thumbnail' => $newname,
                    'title' => $request->title,
                    'slug' => Str::slug($request->slug,'-'),
                    'price' => $request->price,
                    'short_description' => $request->short_description,
                    'description' => $request->description,
                ]);
                return redirect()->route('product.index')->with('success','Product Created Successfully');
            }else{
                Product::create([
                    'user_id' => auth()->user()->id,
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'slug' => Str::slug($request->title,'-'),
                    'price' => $request->price,
                    'short_description' => $request->short_description,
                    'description' => $request->description,
                    'thumbnail' => $newname,
                ]);
                 return redirect()->route('product.index')->with('success','Product Created Successfully');

            }
    }
    }

    /**
     * Display the specified resource.
     */
    public function status($id)
    {
        $product = Product::where('id',$id)->first();
        if($product->status == 'deactive'){
             $product->update([
                'status' => 'active',
                'updated_at' => now(),
            ]);
            return back()->with('success','Status Actived');
        }else{
            $product->update([
                'status' => 'deactive',
                'updated_at' => now(),
            ]);
            return back()->with('success','Status Deactived');
        }
    }
    public function show(Product $product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('status',"active")->latest()->get();
        $product = Product::where('id',$product->id)->first();
        return view('dashboard.product.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
{
    $manager = new ImageManager(new Driver());

    $request->validate([
        'title' => 'required',
        'thumbnail' => 'nullable|image',
    ]);

    // Handle image update
    if ($request->hasFile('thumbnail')) {

        // Delete old image
        if ($product->thumbnail) {
            $oldimage = public_path('images/product/' . $product->thumbnail);
            if (file_exists($oldimage)) {
                unlink($oldimage);
            }
        }

        // Save new image
        $newname = auth()->id() . '-' . Str::random(4) . '.' .
                   $request->file('thumbnail')->getClientOriginalExtension();

        $image = $manager->read($request->file('thumbnail'));
        $image->toPng()->save(public_path('images/product/' . $newname));

        $product->thumbnail = $newname;
    }

    // Update product data
    $product->update([
        'user_id' => auth()->id(),
        'category_id' => $request->category_id,
        'title' => $request->title,
        'slug' => Str::slug($request->slug ?? $request->title, '-'),
        'price' => $request->price,
        'short_description' => $request->short_description,
        'description' => $request->description,
        'thumbnail' => $product->thumbnail,
    ]);

    return redirect()->route('product.index')->with('success', 'Product Updated Successfully');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->thumbnail){
            $oldthumbnail = public_path('images/product/'.$product->thumbnail);
            if(file_exists($oldthumbnail)){
                unlink($oldthumbnail);
            }
        }
        $product->delete();return back()->with('success','Product Deleted Successfully');
    }
}
