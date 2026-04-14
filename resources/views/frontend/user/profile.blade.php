<div style="max-width: 700px; margin: auto; font-family: Arial;">

    <!-- PROFILE CARD -->
    <div style="background:#fff; padding:20px; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.08); text-align:center;">

        <img
            src="{{ $user->image == 'default.png'
                ? asset('images/default/default.png')
                : asset('images/profile/' . $user->image) }}"
            style="width:120px; height:120px; border-radius:50%; object-fit:cover; border:3px solid #eee;"
        >

        <h2 style="margin-top:10px;">{{ $user->name }}</h2>
    </div>
     <!-- COMMENTS SECTION -->
    <div style="margin-top:20px;">

        <h4 style="margin-bottom:10px;">Comments</h4>

        @foreach($user->blogComments as $comment)

            <div style="background:#beffc1; padding:12px; margin-bottom:10px; border-radius:10px; box-shadow:0 1px 5px rgba(0,0,0,0.06);">

                <p style="margin:0;">{{ $comment->message }}</p>

                <small style="color:gray;">
                    {{ $comment->created_at->diffForHumans() }}
                </small>

            </div>

        @endforeach

    </div>
    <!-- MESSAGE BOX -->
    <div style="margin-top:20px; background:#fff; padding:20px; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.08);">

        <h4 style="margin-bottom:10px;">Send Message</h4>

        <form method="POST" action="{{ route('message.send', $user->id) }}">
            @csrf

            <textarea
                name="message"
                required
                placeholder="Write your message..."
                style="width:100%; height:90px; padding:10px; border-radius:8px; border:1px solid #ddd; resize:none;"
            ></textarea>

            <button
                style="margin-top:10px; background:#1877f2; color:#fff; border:none; padding:10px 20px; border-radius:8px; cursor:pointer;"
            >
                Send
            </button>
        </form>

    </div>


</div>
