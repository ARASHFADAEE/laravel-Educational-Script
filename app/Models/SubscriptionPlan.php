<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'duration_days',
        'description'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_subscription_plan')
                    ->withPivot('price')
                    ->withTimestamps();
    }
}
