<!-- resources/views/frontend/partials/single-blog/comments.blade.php -->
<div class="space-y-5">
    <!-- article:comments:title -->
    <div class="flex items-center gap-3 mb-5">
        <div class="flex items-center gap-1">
            <div class="w-1 h-1 bg-foreground rounded-full"></div>
            <div class="w-2 h-2 bg-foreground rounded-full"></div>
        </div>
        <div class="font-black text-foreground">دیدگاه و پرسش</div>
    </div>
    <!-- end article:comments:container -->

    <!-- article:comments:form:wrapper -->
    <div class="bg-background border border-border rounded-3xl p-5 mb-5">
        <div class="flex items-center gap-3 mb-5">
            <div class="flex items-center gap-1">
                <div class="w-1 h-1 bg-foreground rounded-full"></div>
                <div class="w-2 h-2 bg-foreground rounded-full"></div>
            </div>
            <div class="font-black text-xs text-foreground">
                ارسال دیدگاه یا پرسش
            </div>
        </div>
        <div id="reply-form" class="hidden mb-3">
            <div class="flex flex-wrap items-center gap-3 mb-3">
                <span class="font-semibold text-xs text-muted">در پاسخ به</span>
                <span class="block w-1 h-1 bg-border rounded-full"></span>
                <a href="#" id="reply-to-name"
                    class="line-clamp-1 font-semibold text-sm text-foreground hover:text-primary"></a>
                <button type="button" onclick="cancelReply()" id="cancel-reply"
                    class="line-clamp-1 font-semibold text-sm text-red-500 mr-auto">
                    لغو پاسخ
                </button>
            </div>
        </div>
        <form id="comment-form" action="{{ route('comments.store') }}" method="POST" class="flex flex-col space-y-5">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="hidden" name="parent_id" id="parent_id" value="">

            <textarea name="body" id="text" rows="5"
                class="form-textarea w-full !ring-0 !ring-offset-0 bg-secondary border-0 focus:border-border border-border rounded-xl text-sm text-foreground p-5"
                placeholder="متن مورد نظر خود را وارد کنید ..." required></textarea>

            <button type="submit"
                class="h-10 inline-flex items-center justify-center gap-1 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4 mr-auto">
                <span class="font-semibold text-sm">ثبت دیدگاه یا پرسش</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </form>
    </div>
    <!-- end article:comments:form:wrapper -->

    <!-- article:comments:wrapper -->
    <div id="comments-container" class="space-y-3">
        @forelse($comments as $comment)
            @include('frontend.partials.single-blog.comment-item', ['comment' => $comment])
        @empty
            <div id="no-comments" class="text-center py-8 text-muted">
                هنوز دیدگاهی ثبت نشده است.
            </div>
        @endforelse

        <!-- نمایش صفحه‌بندی -->
        @if ($comments->hasPages())
            <div class="mt-6">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
    <!-- end article:comments:wrapper -->
</div>
<!-- end article:comments:container -->
<script>
    // توابع کمکی
    function getCsrfToken() {
        // چندین روش برای دریافت CSRF token
        return document.querySelector('meta[name="csrf-token"]')?.content ||
            document.querySelector('input[name="_token"]')?.value ||
            '';
    }

    let currentReplyId = null;
    let currentReplyName = null;

    function replyToComment(commentId, userName) {
        currentReplyId = commentId;
        currentReplyName = userName;

        // نمایش فرم پاسخ
        document.getElementById('parent_id').value = commentId;
        document.getElementById('reply-to-name').innerText = userName;
        document.getElementById('reply-form').classList.remove('hidden');
        document.getElementById('cancel-reply').classList.remove('hidden');

        // اسکرول به فرم
        document.getElementById('comment-form').scrollIntoView({
            behavior: 'smooth'
        });
    }

    function cancelReply() {
        currentReplyId = null;
        currentReplyName = null;

        document.getElementById('parent_id').value = '';
        document.getElementById('reply-to-name').innerText = '';
        document.getElementById('reply-form').classList.add('hidden');
        document.getElementById('cancel-reply').classList.add('hidden');
    }

    // تابع نمایش نوتیفیکیشن
    function showNotification(message, type = 'success') {
        // ایجاد المان نوتیفیکیشن
        const notification = document.createElement('div');
        notification.className = `fixed top-4 left-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white text-sm transition-all duration-300 transform ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        'bg-blue-500'
    }`;
        notification.textContent = message;
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';

        // اضافه کردن به صفحه
        document.body.appendChild(notification);

        // انیمیشن نمایش
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 10);

        // حذف خودکار بعد از 3 ثانیه
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // ارسال فرم کامنت
    document.getElementById('comment-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        // نمایش لودینگ
        submitBtn.innerHTML = 'در حال ارسال...';
        submitBtn.disabled = true;

        // دریافت CSRF token
        const csrfToken = getCsrfToken();

        if (!csrfToken) {
            showNotification('خطا در احراز هویت. لطفاً صفحه را رفرش کنید.', 'error');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            return;
        }

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
                // اضافه کردن کامنت جدید به لیست
                const commentsContainer = document.getElementById('comments-container');

                if (currentReplyId) {
                    // اگر پاسخ است
                    let repliesContainer = document.getElementById(`replies-${currentReplyId}`);
                    if (!repliesContainer) {
                        // اگر کانتینر پاسخ وجود ندارد، ایجاد کن
                        const commentElement = document.getElementById(`comment-${currentReplyId}`);
                        const repliesDiv = document.createElement('div');
                        repliesDiv.id = `replies-${currentReplyId}`;
                        repliesDiv.className =
                            'relative before:content-[\'\'] before:absolute before:-top-3 before:right-8 before:w-px before:h-[calc(100%-24px)] before:bg-border after:content-[\'\'] after:absolute after:bottom-9 after:right-8 after:w-8 after:h-px after:bg-border space-y-3 pr-16';
                        commentElement.appendChild(repliesDiv);
                        repliesContainer = repliesDiv;
                    }
                    repliesContainer.innerHTML = data.html + repliesContainer.innerHTML;
                } else {
                    // اگر کامنت اصلی است
                    // اگر پیغام "دیدگاهی وجود ندارد" هست، آن را حذف کن
                    const noCommentsDiv = document.getElementById('no-comments');
                    if (noCommentsDiv) {
                        noCommentsDiv.remove();
                    }

                    // کامنت جدید را اضافه کن
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data.html;
                    commentsContainer.prepend(tempDiv.firstElementChild);
                }

                // ریست فرم
                this.reset();
                cancelReply();

                // نمایش پیام موفقیت
                showNotification(data.message || 'دیدگاه با موفقیت ثبت شد.', 'success');
            } else {
                // نمایش خطاها
                if (data.errors) {
                    Object.keys(data.errors).forEach(key => {
                        showNotification(data.errors[key][0], 'error');
                    });
                } else if (data.message) {
                    showNotification(data.message, 'error');
                } else {
                    showNotification('خطایی در ارسال دیدگاه رخ داد.', 'error');
                }

                // برای دیباگ
                console.error('Error from server:', data);
            }
        } catch (error) {
            console.error('Network error:', error);
            showNotification('خطایی در ارتباط با سرور رخ داد.', 'error');
        } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });

    // لایک کردن کامنت
    async function likeComment(commentId) {
        const csrfToken = getCsrfToken();

        if (!csrfToken) {
            showNotification('خطا در احراز هویت.', 'error');
            return;
        }

        try {
            const response = await fetch(`/comments/${commentId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                const likesCountElement = document.getElementById(`likes-count-${commentId}`);

                if (likesCountElement) {
                    likesCountElement.textContent = data.likes_count;
                } else {
                    // اگر المان وجود ندارد، ایجاد کن
                    const likeBtn = document.querySelector(`button[onclick="likeComment(${commentId})"]`);
                    if (likeBtn) {
                        const span = document.createElement('span');
                        span.id = `likes-count-${commentId}`;
                        span.className =
                            'absolute -top-1 -right-1 inline-flex bg-red-500 rounded-full text-xs text-white px-1';
                        span.textContent = data.likes_count;
                        likeBtn.appendChild(span);
                    }
                }

                showNotification('لایک ثبت شد!', 'success');
            } else {
                showNotification(data.message || 'خطا در ثبت لایک', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('خطایی در ارتباط با سرور رخ داد.', 'error');
        }
    }

    // حذف کامنت
    async function deleteComment(commentId) {
        if (!confirm('آیا از حذف این دیدگاه مطمئن هستید؟')) return;

        const csrfToken = getCsrfToken();

        if (!csrfToken) {
            showNotification('خطا در احراز هویت.', 'error');
            return;
        }

        try {
            const response = await fetch(`/comments/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                const commentElement = document.getElementById(`comment-${commentId}`);
                if (commentElement) {
                    commentElement.remove();
                }

                // اگر کامنتی باقی نمانده، پیام نشان بده
                const commentsContainer = document.getElementById('comments-container');
                if (commentsContainer && commentsContainer.children.length === 0) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.id = 'no-comments';
                    emptyDiv.className = 'text-center py-8 text-muted';
                    emptyDiv.textContent = 'هنوز دیدگاهی ثبت نشده است.';
                    commentsContainer.appendChild(emptyDiv);
                }

                showNotification(data.message || 'دیدگاه با موفقیت حذف شد.', 'success');
            } else {
                showNotification(data.message || 'خطا در حذف دیدگاه', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('خطایی در ارتباط با سرور رخ داد.', 'error');
        }
    }
</script>
