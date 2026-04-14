<h3 style="margin-bottom:15px;">💬 Messages</h3>

@forelse($messages as $msg)

@php
    $isMe = $msg->sender_id == auth()->id();
    $user = $isMe ? $msg->receiver : $msg->sender;
@endphp

<a href="{{ route('chat.open', $user->id) }}"
   style="text-decoration:none; color:inherit;">

    <div style="
        display:flex;
        align-items:center;
        gap:10px;
        padding:12px;
        margin-bottom:10px;
        background:#fff;
        border-radius:12px;
        box-shadow:0 2px 8px rgba(0,0,0,0.06);
        transition:0.2s;
    "
    onmouseover="this.style.transform='scale(1.01)'"
    onmouseout="this.style.transform='scale(1)'">

        <!-- Avatar -->
        <div style="
            width:45px;
            height:45px;
            border-radius:50%;
            background:#ddd;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:bold;
        ">
            {{ strtoupper(substr($user->name,0,1)) }}
        </div>

        <!-- Text -->
        <div style="flex:1;">
            <div style="font-weight:bold;">
                {{ $user->name }}
            </div>

            <div style="font-size:13px; color:gray;">
                {{ $isMe ? 'You: ' : '' }}
                {{ \Illuminate\Support\Str::limit($msg->message, 35) }}
            </div>
            <div style="font-size:11px; color:gray; margin-top:4px;">
                {{ \Carbon\Carbon::parse($msg->created_at)->format('h:i A') }}
            </div>
        </div>

    </div>

</a>

@empty
    <p>No messages found</p>
@endforelse
