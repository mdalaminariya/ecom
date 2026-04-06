<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BlogController extends Controller
{

public function list()
{
    $blogs = Blog::with('user')->latest()->get();
    $categories = Category::where('status', 'active')->latest()->get();
    $recentBlogs = Blog::latest()->take(5)->get();

    return view('frontend.blog.index', compact('blogs', 'categories', 'recentBlogs'));
}
    // Dashboard: List all blogs
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('dashboard.blog.index', compact('blogs'));
    }

    // Dashboard: Show create blog form
    public function create()
    {
        $categories = Category::where('status','active')->latest()->get();
        return view('dashboard.blog.create', compact('categories'));
    }

    // Dashboard: Store new blog
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

        $new_name = null;
        if($request->hasFile('thumbnail')){
            $new_name = auth()->user()->id.'-'.Str::random(4).'.'.$request->file('thumbnail')->getClientOriginalExtension();
            $image = $manager->read($request->file('thumbnail'));
            $image->toPng()->save(public_path('images/blog/'.$new_name));
        }

        Blog::create([
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'thumbnail' => $new_name,
            'title' => ucfirst($request->title),
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
            'short_description' => $request->short_description,
            'description' => $request->description,
        ]);

        return redirect()->route('blog.index')->with('success', 'Blog Inserted Successfully');
    }
public function storeComment(Request $request, $blog_id)
{
    $request->validate([
        'comment'   => 'required|string',
        'parent_id' => 'nullable|exists:blog_comments,id',
        'name'      => 'nullable|string|max:255',
        'email'     => 'nullable|email|max:255',
    ]);

    $blog = Blog::findOrFail($blog_id);

    // Determine if user is logged in
    $user_id = auth()->check() ? auth()->id() : null;
    $name    = auth()->check() ? null : $request->name;
    $email   = auth()->check() ? null : $request->email;

    // Create the comment
    $blog->blog_comments()->create([
        'user_id'   => $user_id,             // null for guest
        'name'      => $name,
        'email'     => $email,
        'message'   => $request->comment,    // your DB column is 'message'
        'parent_id' => $request->parent_id,  // null if top-level
    ]);

    return back()->with('success', 'Comment added successfully!');
}

    // Dashboard: Toggle blog status

    public function status($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->status = $blog->status === 'deactive' ? 'active' : 'deactive';
        $blog->save();

        return back()->with('success', 'Blog '.$blog->status.' successfully');
    }

    // Dashboard: Show edit form
    public function edit(Blog $blog)
    {
        $categories = Category::where('status','active')->latest()->get();
        return view('dashboard.blog.edit', compact('blog', 'categories'));
    }

    // Dashboard: Update blog
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

        $data = [
            'category_id' => $request->category_id,
            'title' => ucfirst($request->title),
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
            'short_description' => $request->short_description,
            'description' => $request->description,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($blog->thumbnail && file_exists(public_path('images/blog/'.$blog->thumbnail))) {
                unlink(public_path('images/blog/'.$blog->thumbnail));
            }
            $new_name = auth()->user()->id.'-'.Str::random(4).'.'.$request->file('thumbnail')->getClientOriginalExtension();
            $image = $manager->read($request->file('thumbnail'));
            $image->toPng()->save(public_path('images/blog/'.$new_name));
            $data['thumbnail'] = $new_name;
        }

        $blog->update($data);
        return redirect()->route('blog.index')->with('success', 'Blog Updated Successfully');
    }

    // Dashboard: Delete blog
    public function destroy(Blog $blog)
    {
        if ($blog->thumbnail && file_exists(public_path('images/blog/'.$blog->thumbnail))) {
            unlink(public_path('images/blog/'.$blog->thumbnail));
        }

        $blog->delete();
        return redirect()->route('blog.index')->with('success', 'Blog Deleted Successfully');
    }

    // Frontend: Blog details with comments
public function blog_details($slug)
{
    // Fetch blog with user, category, and all top-level comments with nested replies
    $blog = Blog::with([
        'user', // author
        'category',
        'blog_comments' => function($q) {
            $q->whereNull('parent_id')   // top-level comments only
              ->with(['user', 'repliesRecursive']) // eager load nested replies recursively
              ->latest();
        }
    ])
    ->where('slug', $slug)
    ->firstOrFail();

    // Recent blogs for sidebar
    $recentBlogs = Blog::latest()->take(5)->get();

    // Active categories
    $categories = Category::where('status', 'active')->latest()->get();

    return view('frontend.blog.blogDetails.details', compact('blog', 'categories', 'recentBlogs'));
}

    public function blog_comments()
    {
        $comments = BlogComment::latest()->paginate(10);
        return view('dashboard.comment.blogcomment', compact('comments'));
    }

    public function blog_comments_delete($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->delete();
        return back()->with('success', 'Comment Deleted Successfully');
    }
}
