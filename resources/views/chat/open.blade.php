
<div id="chat-box"
     style="
        height:420px;
        overflow-y:auto;
        padding:15px;
        background:linear-gradient(180deg,#f7f9fc,#ffffff);
        border-radius:15px;
        box-shadow:0 2px 10px rgba(0,0,0,0.05);
     "></div>
     @foreach($messages as $msg)
    <div style="
        display:flex;
        justify-content: {{ $msg->sender_id == auth()->id() ? 'flex-end' : 'flex-start' }};
        margin-bottom:10px;
    ">

        <div style="
            max-width:70%;
            padding:10px 14px;
            border-radius:18px;
            font-size:14px;
            line-height:1.4;
            position:relative;

            background: {{ $msg->sender_id == auth()->id()
                ? 'linear-gradient(135deg,#25D366,#20b358)'
                : '#f1f1f1' }};

            color: {{ $msg->sender_id == auth()->id() ? 'white' : '#333' }};
            box-shadow:0 2px 6px rgba(0,0,0,0.08);
        ">

            {{ $msg->message }}
            <div style="font-size:11px; color:rgb(0, 0, 0); margin-top:4px;">
                {{ \Carbon\Carbon::parse($msg->created_at)->format('h:i A') }}
            </div>

        </div>
    </div>
@endforeach

</div>

<form id="chat-form" method="POST" action="{{ route('chat.send') }}"
      style="
        display:flex;
        align-items:center;
        gap:10px;
        padding:12px;
        margin-top:10px;
        background:#fff;
        border-radius:20px;
        box-shadow:0 4px 15px rgba(0,0,0,0.08);
      ">

    @csrf

    <input type="hidden" name="receiver_id" value="{{ $user->id }}">

    <!-- Emoji -->
<div id="emoji-box"
     style="
        display:none;
        position:absolute;
        bottom:80px;
        left:20px;
        background:#fff;
        border:1px solid #ddd;
        padding:10px;
        border-radius:10px;
        box-shadow:0 4px 15px rgba(0,0,0,0.1);
        max-width:200px;
        flex-wrap:wrap;
     ">

    <span class="emoji">😀</span>
    <span class="emoji">😂</span>
    <span class="emoji">😍</span>
    <span class="emoji">😎</span>
    <span class="emoji">😭</span>
    <span class="emoji">😡</span>
    <span class="emoji">👍</span>
    <span class="emoji">🙏</span>
    <span class="emoji">🔥</span>
    <span class="emoji">❤️</span>

</div>
<button type="button" id="emoji-btn"
        style="
            border:none;
            background:#f3f3f3;
            width:40px;
            height:40px;
            border-radius:50%;
            cursor:pointer;
            font-size:18px;
        ">
    🙂
</button>

    <!-- Input -->
    <input type="text"
           id="message-input"
           name="message"
           placeholder="Write your message..."
           autocomplete="off"
           required
           style="
                flex:1;
                border:none;
                outline:none;
                padding:12px;
                font-size:14px;
                background:#f7f7f7;
                border-radius:25px;
           ">

    <!-- Send Button (GRADIENT + ICON STYLE) -->
    <button type="submit"
            style="
                width:45px;
                height:45px;
                border:none;
                border-radius:50%;
                background:linear-gradient(135deg,#ff4d4d,#ff7a00,#ffcc00);
                color:white;
                font-size:18px;
                cursor:pointer;
                box-shadow:0 3px 10px rgba(0,0,0,0.2);
                transition:0.2s;
            "
            onmouseover="this.style.transform='scale(1.1)'"
            onmouseout="this.style.transform='scale(1)'">

        ➤
    </button>

</form>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const input = document.getElementById("message-input");
    const form = document.getElementById("chat-form");

    const emojiBtn = document.getElementById("emoji-btn");
    const emojiBox = document.getElementById("emoji-box");

    // Show / hide emoji box
    emojiBtn.addEventListener("click", function () {
        emojiBox.style.display =
            emojiBox.style.display === "flex" ? "none" : "flex";
    });

    // Insert emoji into input
    document.querySelectorAll(".emoji").forEach(function (el) {
        el.style.cursor = "pointer";
        el.style.fontSize = "20px";
        el.style.margin = "5px";

        el.addEventListener("click", function () {
            input.value += el.innerText;
            input.focus();
        });
    });

    // Enter key send
    input.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            form.submit();
        }
    });

    // Close emoji box when clicking outside
    document.addEventListener("click", function (e) {
        if (!emojiBox.contains(e.target) && e.target !== emojiBtn) {
            emojiBox.style.display = "none";
        }
    });

});
</script>
