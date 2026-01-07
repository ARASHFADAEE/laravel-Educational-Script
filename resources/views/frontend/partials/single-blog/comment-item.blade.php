<!-- resources/views/frontend/partials/single-blog/comment-item.blade.php -->
<div id="comment-{{ $comment->id }}" class="space-y-3">
    <div class="bg-background border border-border rounded-3xl space-y-3 p-5">
        <div class="flex sm:flex-nowrap flex-wrap sm:flex-row flex-col sm:items-center sm:justify-between gap-5 border-b border-border pb-3">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                    @if (!empty($comment->user->avatar))
                        
                    <img src="{{asset('storage')}}/{{ $comment->user->avatar }} " 
                         class="w-full h-full object-cover" 
                         alt="{{ $comment->user->name }}">

                 @else
                <img src="{{asset('/image/avatar/avatar.png')}} " 
                         class="w-full h-full object-cover" 
                         alt="{{ $comment->user->name }}">

                 @endif

                </div>
                <div class="flex flex-col items-start space-y-1">
                    <a href="#"
                       class="line-clamp-1 font-semibold text-sm text-foreground hover:text-primary">
                        {{ $comment->user->name ?? 'کاربر ناشناس' }}
                    </a>
                    <span class="text-xs text-muted">
                        {{ $comment->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-3 sm:mr-0 mr-auto">
                <button type="button"
                        onclick="replyToComment({{ $comment->id }}, '{{ $comment->user->name }}')"
                        class="flex items-center h-9 gap-1 bg-secondary rounded-full text-muted transition-colors hover:text-primary px-4">
                    <span class="text-xs">پاسخ</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M12.207 2.232a.75.75 0 0 0 .025 1.06l4.146 3.958H6.375a5.375 5.375 0 0 0 0 10.75H9.25a.75.75 0 0 0 0-1.5H6.375a3.875 3.875 0 0 1 0-7.75h10.003l-4.146 3.957a.75.75 0 0 0 1.036 1.085l5.5-5.25a.75.75 0 0 0 0-1.085l-5.5-5.25a.75.75 0 0 0-1.06.025Z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                
                @if(auth()->check() && auth()->id() != $comment->user_id)
                <button type="button"
                        onclick="likeComment({{ $comment->id }})"
                        class="flex items-center justify-center relative w-9 h-9 bg-secondary rounded-full text-muted transition-colors hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="m9.653 16.915-.005-.003-.019-.01a20.759 20.759 0 0 1-1.162-.682 22.045 22.045 0 0 1-2.582-1.9C4.045 12.733 2 10.352 2 7.5a4.5 4.5 0 0 1 8-2.828A4.5 4.5 0 0 1 18 7.5c0 2.852-2.044 5.233-3.885 6.82a22.049 22.049 0 0 1-3.744 2.582l-.019.01-.005.003h-.002a.739.739 0 0 1-.69.001l-.002-.001Z">
                        </path>
                    </svg>
                    @if($comment->likes_count > 0)
                    <span id="likes-count-{{ $comment->id }}"
                        class="absolute -top-1 -right-1 inline-flex bg-red-500 rounded-full text-xs text-white px-1">
                        {{ $comment->likes_count }}
                    </span>
                    @endif
                </button>
                @endif
                
                @if(auth()->check() && (auth()->id() == $comment->user_id ))
                <button type="button"
                        onclick="deleteComment({{ $comment->id }})"
                        class="flex items-center justify-center w-9 h-9 bg-secondary rounded-full text-muted transition-colors hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
                @else
                <p><p>
                @endif
            </div>
        </div>
        <p class="text-sm text-muted whitespace-pre-line">
            {{ $comment->body }}
        </p>
    </div>

    <!-- نمایش پاسخ‌ها -->
    @if($comment->replies && $comment->replies->count() > 0)
    <div id="replies-{{ $comment->id }}" class="relative before:content-[''] before:absolute before:-top-3 before:right-8 before:w-px before:h-[calc(100%-24px)] before:bg-border after:content-[''] after:absolute after:bottom-9 after:right-8 after:w-8 after:h-px after:bg-border space-y-3 pr-16">
        @foreach($comment->replies as $reply)
            @include('frontend.partials.single-blog.comment-item', ['comment' => $reply])
        @endforeach
    </div>
    @endif
</div>