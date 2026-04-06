@props(['comment', 'level' => 0])

<div class="comment-list" style="margin-left: {{ $level ?? 0 }}px;">
    <div class="single-comment justify-content-between d-flex">
        <div class="user d-flex">
            <div class="thumb"><img src="{{ asset('img/comment/comment_1.png') }}" alt="user"></div>
            <div class="desc">
                <h5>{{ $comment->user->name ?? $comment->name }}</h5>
                <p class="date">{{ $comment->created_at->format('F j, Y \a\t g:i a') }}</p>
                <p class="comment">{{ $comment->message }}</p>
                <a href="javascript:void(0);" onclick="setReply({{ $comment->id }}, '{{ $comment->user->name ?? $comment->name }}')">Reply</a>

                @foreach($comment->replies as $reply)
                    <x-blog-comment :comment="$reply" :level="($level ?? 0) + 30"/>
                @endforeach
            </div>
        </div>
    </div>
</div>
