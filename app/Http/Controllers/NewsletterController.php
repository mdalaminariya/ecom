<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{

public function index()
{
    $subscribers = Newsletter::latest()->get();
    return view('dashboard.subscriber.index', compact('subscribers'));
}

public function delete($id){
    $subscriber = Newsletter::where('id', $id)->first();
    $subscriber->delete();
    return redirect()->route('subscriber')->with('success', 'Subscriber deleted successfully.');
}
public function subscribe(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:newsletters,email'
    ]);

    Newsletter::create([
        'email' => $request->email
    ]);

    session(['newsletter_email' => $request->email]);

    return response()->json([
        'success' => 'Successfully subscribed!'
    ]);
}
}
