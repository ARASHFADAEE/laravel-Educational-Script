<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'body',
        'parent_id',
        'likes_count',
        'status', // اضافه کردن status
    ];

    // تنظیم مقادیر پیش‌فرض
    protected $attributes = [
        'likes_count' => 0,
        'status' => 'pending', // پیش‌فرض pending
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies.user', 'user');
    }

    // فقط کامنت‌های والد (بدون parent_id)
    public function scopeParentComments($query)
    {
        return $query->whereNull('parent_id');
    }

    // اسکوپ برای کامنت‌های تایید شده
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // اسکوپ برای کامنت‌های در انتظار
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}