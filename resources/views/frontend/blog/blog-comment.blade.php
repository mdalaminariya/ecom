<div class="comment-list" style="margin-left: {{ $level ?? 0 }}px;">
    <div class="single-comment justify-content-between d-flex">
        <div class="user d-flex">
          <div class="thumb">
    @php
        $userImage = auth()->user()->image ?? null;
        $isDefault = $userImage === 'default.png'; // or whatever your default file is named
    @endphp

    @if ($isDefault || !$userImage)
        <!-- Show default avatar -->
        <img src="{{ asset('images/default/default.png') }}" alt="user" width="50">
    @else
        <!-- Show user-uploaded avatar -->
        <img src="{{ asset('images/profile/' . $userImage) }}" alt="user" width="50">
    @endif
</div>
            <div class="desc">
                <h5>{{ $comment->user->name ?? $comment->name }}</h5>
                <p class="date">{{ $comment->created_at->format('F j, Y \a\t g:i a') }}</p>
                <p class="comment">{{ $comment->message }}</p>
                <a href="javascript:void(0);" onclick="setReply({{ $comment->id }}, '{{ $comment->user->name ?? $comment->name }}')">Reply</a>

                @if($comment->replies->count())
                    @foreach($comment->replies as $reply)
                        @include('frontend.blog.blog-comment', ['comment' => $reply, 'level' => ($level ?? 0) + 30])
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
