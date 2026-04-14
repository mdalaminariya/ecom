<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Message;

class ChatController extends Controller
{
    // Send message
public function send(Request $request)
{
    $request->validate([
        'message' => 'required',
        'receiver_id' => 'required'
    ]);

    Message::create([
        'name' => auth()->user()->name,
        'sender_id' => auth()->id(),
        'receiver_id' => $request->receiver_id,
        'message' => $request->message,
    ]);

    return redirect()->route('chat.open', $request->receiver_id)->with('success', 'Message sent successfully!');
}
    // Inbox
public function inbox()
{
    $userId = auth()->id();

    // Step 1: get latest message per user (conversation)
    $sub = Message::selectRaw('MAX(id) as id')
        ->where(function ($q) use ($userId) {
            $q->where('sender_id', $userId)
              ->orWhere('receiver_id', $userId);
        })
        ->groupByRaw("
            CASE
                WHEN sender_id = $userId THEN receiver_id
                ELSE sender_id
            END
        ");

    // Step 2: get full messages
    $messages = Message::with(['sender', 'receiver'])
        ->whereIn('id', $sub)
        ->orderByDesc('created_at')
        ->get();

    return view('chat.inbox', compact('messages'));
}
    public function unreadCount()
        {
            $count = Message::where('receiver_id', auth()->id())
                ->where('is_read', false)
                ->count();

            return response()->json([
                'count' => $count
            ]);
        }

        public function open($id)
{
    $user = \App\Models\User::findOrFail($id);

    $messages = Message::where(function ($q) use ($id) {
            $q->where('sender_id', auth()->id())
              ->where('receiver_id', $id);
        })
        ->orWhere(function ($q) use ($id) {
            $q->where('sender_id', $id)
              ->where('receiver_id', auth()->id());
        })
        ->orderBy('created_at', 'asc')
        ->with(['sender', 'receiver'])
        ->get();

    // mark as read
    Message::where('sender_id', $id)
        ->where('receiver_id', auth()->id())
        ->update(['is_read' => 1]);

    return view('chat.open', compact('messages', 'user'));
}
}
