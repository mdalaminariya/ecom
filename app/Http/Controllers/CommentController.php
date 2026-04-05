<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

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
        $comment->delete();
        return back()->with('success', 'Comment deleted successfully!');
    }
    //backend comment management end

    //frontend comment store start
    public function store(Request $request)
    {
        // Validate the request
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|email|max:255',
            'message'    => 'required|string',
            'parent_id'  => 'nullable|exists:comments,id',
            'rating'     => 'nullable|numeric|min: 0|max:5', // added rating
        ]);

        // Create the comment
        Comment::create($data);

        return back()->with('success', 'Comment posted successfully!');
    }
    //frontend comment store end
}
