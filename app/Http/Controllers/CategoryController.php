<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use function Illuminate\Support\now;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('dashboard.category.index',compact('categories'));
    }

    public function store(Request $request){
        $manager = new ImageManager(new Driver());

         $request->validate([
            'title' => 'required|string',
            'thumbnail' => 'required|image',
         ]);

         if($request->hasFile('thumbnail')){
            $newname = auth()->user()->id .'-'.now()->format('Y-m-d-H-i-s').'-'.rand(1111,9999).'.'.$request->file('thumbnail')->getClientOriginalExtension();
            $image = $manager->read($request->file('thumbnail'));
            $image->toPng()->save(base_path('public/images/category/'.$newname));

            if($request->slug){
                Category::create([
                    'title' => Str::ucfirst($request->title),
                    'slug' => Str::slug($request->slug,'-'),
                    'thumbnail' => $newname,
                    'created_at' => now(),
                ]);
                return back()->with('success','Category inserted successfully');
            }else{
                Category::create([
                    'title' => Str::ucfirst($request->title),
                    'slug' => Str::slug($request->title,'-'),
                    'thumbnail' => $newname,
                    'created_at' => now(),
                ]);
                return back()->with('success','Category inserted successfully');
            }
         }else{
            return back()->withErrors(['error' => 'Information is missing'])->withInput();
         }
    }

    public function status($slug){
        $category = Category::where('slug',$slug)->first();
        if($category->status == 'deactive'){
             $category->update([
                'status' => 'active',
                'updated_at' => now(),
            ]);
            return back()->with('success','Status Actived');
        }else{
            $category->update([
                'status' => 'active',
                'updated_at' => now(),
            ]);
            return back()->with('success','Status Actived');
    }
    }
    public function edit($slug){
        $category = Category::where('slug',$slug)->first();
        return view('dashboard.category.edit',compact('category'));

    }

    public function update(Request $request,$slug){
        $manager = new ImageManager(new Driver());
        $request->validate([
            'title' => 'required|string',
         ]);
$category = Category::where('slug',$slug)->first();
         if($request->hasFile('thumbnail')){
            if($category->thumbnail){
                $oldimage = base_path('public/images/category/'.$category->thumbnail);
                if(file_exists($oldimage)){
                    unlink($oldimage);
                }
            }
            $newname = auth()->user()->id.''.now()->format('M d,y').''.rand(1111,9999).'.'.$request->file('thumbnail')->getClientOriginalExtension();
            $image = $manager->read($request->file('thumbnail'));
            $image->toPng()->save(base_path('public/images/category/'.$newname));

           if($request->slug){
             Category::where('slug',$slug)->update([
                'title' => Str::ucfirst($request->title),
                'slug' =>Str::slug($request->slug,'-'),
                'thumbnail' => $newname,
                'updated_at' => now(),
            ]);
            return redirect()->route('category.index')->with('success','Category updated successfully');
           }else{
             Category::where('slug',$slug)->update([
                'title' => Str::ucfirst($request->title),
                'slug' =>Str::slug($request->title,'-'),
                'thumbnail' => $newname,
                'updated_at' => now(),
            ]);
            return redirect()->route('category.index')->with('success','Category updated successfully');
           }
         }else{
            return redirect()->route('category.index')->with('error','Information is missing');
         }


    }

    public function delete($slug){
        $category = Category::where('slug',$slug)->first();
        if($category->thumbnail){
            $oldimage = base_path('public/images/category/'.$category->thumbnail);
            if(file_exists($oldimage)){
                unlink($oldimage);
            }
        }
        $category = Category::where('slug',$slug)->delete();
        return back()->with('success','Category deleted successfully');
    }
}
