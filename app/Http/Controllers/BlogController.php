<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('dashboard.blog.index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status','active')->latest()->get();
        return view('dashboard.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $manager = new ImageManager(new Driver());
        $request->validate([
            'category_id' => 'required',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'thumbnail' => 'required|image'
        ]);

        if($request->hasFile('thumbnail')){
        $new_name = auth()->user()->id.'-'.Str::random(4).'.'.$request->file('thumbnail')->getClientOriginalExtension();
        $image = $manager->read($request->file('thumbnail'));
        $image->toPng()->save('images/blog/'.$new_name);

        if($request->slug){
            Blog::create([
                'user_id' => auth()->user()->id,
                'category_id' => $request->category_id,
                'thumbnail' => $new_name,
                'title' => ucfirst($request->title),
                'slug' => Str::slug($request->slug,'-'),
                'short_description' => $request->short_description,
                'description' => $request->description,
            ]);
            return redirect()->route('blog.index')->with('success','Blog Inserted Successfully');
        }else{
            Blog::create([
                'user_id' => auth()->user()->id,
                'category_id' => $request->category_id,
                'thumbnail' => $new_name,
                'title' => ucfirst($request->title),
                'slug' => Str::slug($request->title,'-'),
                'short_description' => $request->short_description,
                'description' => $request->description,
            ]);
            return redirect()->route('blog.index')->with('success','Blog Inserted Successfully');
        }
    }
}

public function status($id){
    $blog = Blog::where('id',$id)->first();
    if($blog->status == 'deactive'){
        $blog->update([
            'status' => 'active'
        ]);
        return back()->with('success','Blog Activated');
    }else{
        $blog->update([
            'status' => 'deactive'
        ]);
        return back()->with('success','Blog Deactivated');
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $categories = Category::where('status','active')->latest()->get();
        $blogs = Blog::where('id',$blog->id)->latest()->get();
        return view('frontend.blog.index', compact('blogs', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $blog = Blog::where('id',$blog->id)->first();
        $categories = Category::where('status','active')->latest()->get();
        return view('dashboard.blog.edit', compact('blog','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $manager = new ImageManager(new Driver());
        $request->validate([
            'category_id' => 'required',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image'
        ]);

        if($request->hasFile('thumbnail')){
            if($blog->thumbnail){
                $old_image = public_path('images/blog/'.$blog->thumbnail);
                if(file_exists($old_image)){
                    unlink($old_image);
                }
            }
        $new_name = auth()->user()->id.'-'.Str::random(4).'.'.$request->file('thumbnail')->getClientOriginalExtension();
        $image = $manager->read($request->file('thumbnail'));
        $image->toPng()->save('images/blog/'.$new_name);
        $blog->update([
            'category_id' => $request->category_id,
            'thumbnail' => $new_name,
            'title' => ucfirst($request->title),
            'slug' => Str::slug($request->slug,'-'),
            'short_description' => $request->short_description,
            'description' => $request->description,
        ]);
        return redirect()->route('blog.index')->with('success','Blog Updated Successfully');
    }else{
        $blog->update([
            'category_id' => $request->category_id,
            'title' => ucfirst($request->title),
            'slug' => Str::slug($request->slug,'-'),
            'short_description' => $request->short_description,
            'description' => $request->description,
        ]);
        return redirect()->route('blog.index')->with('success','Blog Updated Successfully');
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog = Blog::where('id',$blog->id)->first();
        if($blog->thumbnail){
            $old_image = public_path('images/blog/'.$blog->thumbnail);
            if(file_exists($old_image)){
                unlink($old_image);
            }
        }
        $blog->delete();
        return redirect()->route('blog.index')->with('success','Blog Deleted Successfully');
    }
}
