<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CommentController extends Controller
{
    //backend comment management start
    public function index()
    {
        $comments = Comment::with('product')->latest()->paginate(10);
        return view('dashboard.comment.index', compact('comments'));
    }

 public function delete($id)
{
    $comment = Comment::findOrFail($id);

    // delete replies first
    Comment::where('parent_id', $comment->id)->delete();

    $comment->delete();

    return back()->with('success', 'Comment deleted successfully!');
}
    //backend comment management end

    //frontend comment store start
 public function store(Request $request)
{
    $manager = new ImageManager(new Driver());
    $request->validate([
        'product_id' => 'required',
        'message' => 'required',
        'rating' => 'nullable|numeric',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'parent_id' => 'nullable|exists:comments,id'
    ]);

    $user = Auth::user();

    // HANDLE IMAGE UPLOAD
    if ($request->hasFile('image')) {
        $image = $manager->read($request->file('image'));
        $imageName = auth()->user()->id.'-'.Str::random(4).'.'.$request->file('image')->getClientOriginalExtension();
        $image = $manager->read($request->file('image'));
        $image->toPng()->save(base_path('public/images/comments/'.$imageName));
    }

    // CREATE COMMENT (ALWAYS)
    Comment::create([
        'product_id' => $request->product_id,
        'name' => $user->name,
        'email' => $user->email,
        'message' => $request->message,
        'rating' => $request->rating ?? 0,
        'parent_id' => $request->parent_id,
        'image' => $imageName,
    ]);

    return back()->with('success', 'Comment added successfully!');
}
    //frontend comment store end
}
