<?php

namespace App\Modules\Sms;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Sms', function () {
            return new SmsManager();
        });
    }
}