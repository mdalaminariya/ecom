<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact.index');
    }
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'message' => 'required',
    ]);

    // Save to DB
    $contact = Contact::create($validated);

    // Send Email
    Mail::raw(
        "Name: {$contact->name}\nEmail: {$contact->email}\n\n{$contact->message}",
        function ($message) use ($contact) {
            $message->to('your@email.com')
                    ->subject($contact->subject);
        }
    );

        return redirect()->back()->with('success', 'Message sent successfully!');
}

public function contact_messages()
{
    $contacts = Contact::latest()->paginate(10);
    return view('dashboard.contact.index', compact('contacts'));
}

public function delete($id)
{
    $contact = Contact::where('id', $id)->first();
    $contact->delete();
    return back()->with('success', 'Message deleted successfully!');
}
}
