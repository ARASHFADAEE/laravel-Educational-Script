<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'status',
        'start_date',
        'end_date',
        'amount',
        'transaction_id',
        'payment_method'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Check if subscription is active and not expired
     */
    public function isActive()
    {
        return $this->status === 'active' && 
               $this->end_date && 
               $this->end_date->isFuture();
    }

    /**
     * Check if user has access to course via this subscription
     */
    public function canAccessCourse(Course $course)
    {
        return $this->isActive() && 
               ($course->access_type === 'subscription' || $course->access_type === 'both');
    }
}
