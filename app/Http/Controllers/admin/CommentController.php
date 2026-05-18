<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Show List of Comments with Pending Status
     */
    public function index()
    {
        $comments = Comment::with(['user', 'post'])
            ->whereIn('status', ['pending', 'rejected'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $approvedCount = Comment::where('status', 'approved')->count();
        $pendingCount = Comment::where('status', 'pending')->count();
        $rejectedCount = Comment::where('status', 'rejected')->count();

        return view('admin.comments.index', compact('comments', 'approvedCount', 'pendingCount', 'rejectedCount'));
    }

    /**
     * Show Approved Comments
     */
    public function approved()
    {
        $comments = Comment::with(['user', 'post'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $approvedCount = Comment::where('status', 'approved')->count();
        $pendingCount = Comment::where('status', 'pending')->count();
        $rejectedCount = Comment::where('status', 'rejected')->count();

        return view('admin.comments.approved', compact('comments', 'approvedCount', 'pendingCount', 'rejectedCount'));
    }

    /**
     * Approve a Comment or Reply
     */
    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        return back()->with('success', 'دیدگاه با موفقیت تایید شد.');
    }

    /**
     * Reject a Comment or Reply
     */
    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);

        return back()->with('success', 'دیدگاه با موفقیت رد شد.');
    }

    /**
     * Delete a Comment with its Replies
     */
    public function destroy(Comment $comment)
    {
        // اگر کامنت والد باشد، پاسخ‌های آن را نیز حذف می‌کنیم
        if ($comment->replies()->count() > 0) {
            $comment->replies()->delete();
        }

        $comment->delete();

        return back()->with('success', 'دیدگاه با موفقیت حذف شد.');
    }

    /**
     * Change status to pending (برای بررسی دوباره)
     */
    public function pending(Comment $comment)
    {
        $comment->update(['status' => 'pending']);

        return back()->with('success', 'وضعیت دیدگاه به منتظر بررسی تغییر یافت.');
    }
}
