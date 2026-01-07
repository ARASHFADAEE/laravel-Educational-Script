<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    // نمایش کامنت‌های یک پست (فقط کامنت‌های approved)
    public function index($postId)
    {
        $post = Post::findOrFail($postId);
        
        $comments = Comment::with(['user', 'replies.user'])
            ->where('post_id', $postId)
            ->whereNull('parent_id')
            ->approved() // فقط کامنت‌های تایید شده
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('frontend.partials.single-blog.comments', compact('comments', 'post'));
    }

    // ذخیره کامنت جدید
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string|min:3|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id,
            'status' => 'pending', // به صورت خودکار تایید شود
        ]);

        // بارگیری اطلاعات کاربر برای نمایش
        $comment->load('user');

        // اگر کامنت پاسخ است، والد آن را بارگیری کن
        if ($comment->parent_id) {
            $comment->load('parent.user');
        }

        return response()->json([
            'success' => true,
            'message' => 'دیدگاه با موفقیت ثبت شد.',
            'comment' => $comment,
            'html' => view('frontend.partials.single-blog.comment-item', compact('comment'))->render()
        ]);
    }

    // افزایش تعداد لایک‌ها
    public function like(Comment $comment)
    {
        // جلوگیری از لایک خود کامنت
        if ($comment->user_id !== Auth::id()) {
            $comment->increment('likes_count');
            
            return response()->json([
                'success' => true,
                'likes_count' => $comment->likes_count
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'شما نمی‌توانید دیدگاه خودتان را لایک کنید.'
        ], 403);
    }

    // حذف کامنت
    public function destroy(Comment $comment)
    {
        // بررسی مالکیت کامنت
        if ($comment->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'شما اجازه حذف این دیدگاه را ندارید.'
            ], 403);
        }

        // اگر کامنت والد باشد، پاسخ‌های آن را نیز حذف می‌کنیم
        if ($comment->replies()->count() > 0) {
            $comment->replies()->delete();
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'دیدگاه با موفقیت حذف شد.'
        ]);
    }

    // دریافت پاسخ‌های یک کامنت
    public function replies(Comment $comment)
    {
        $replies = $comment->replies()
            ->with('user')
            ->approved() // فقط پاسخ‌های تایید شده
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'replies' => $replies,
            'html' => view('frontend.partials.single-blog.replies', compact('replies'))->render()
        ]);
    }
}