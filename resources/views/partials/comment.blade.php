<div style="
    display:flex;
    gap:12px;
    padding:12px;
    border-bottom:1px solid #eee;
">

    {{-- Avatar --}}
    @php
        $colors = ['#ff6b6b', '#6c5ce7', '#00b894', '#fdcb6e', '#0984e3'];
        $bg = $colors[crc32($comment->name) % count($colors)];
        $initial = strtoupper(substr($comment->name, 0, 1));
    @endphp

    <div style="
        width:40px;
        height:40px;
        border-radius:50%;
        background: {{ $bg }};
        color:white;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:bold;
        font-size:16px;
        flex-shrink:0;
    ">
        {{ $initial }}
    </div>

    {{-- Content --}}
    <div style="flex:1;">

        {{-- Name --}}
        <h6 style="margin:0; font-weight:600; font-size:14px;">
            {{ $comment->name }}
        </h6>

        {{-- Rating --}}
        <div style="margin:2px 0 4px;">
            @for ($i = 1; $i <= 5; $i++)
                @if($i <= floor($comment->rating))
                    <i class="fa-solid fa-star" style="color:#FFD700; font-size:13px;"></i>
                @else
                    <i class="fa-regular fa-star" style="color:#ccc; font-size:13px;"></i>
                @endif
            @endfor
        </div>

        {{-- Comment (NOW properly under rating) --}}
        <p style="
            margin:0;
            font-size:13px;
            color:#555;
            line-height:1.4;
        ">
            {{ $comment->message }}
        </p>

    </div>
</div>
