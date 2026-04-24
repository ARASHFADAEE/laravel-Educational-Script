<?php

namespace App\Jobs;

use App\Modules\Sms\Facades\Sms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOtpSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $code;
    protected string $phone;

    /**
     * Create a new job instance.
     */
    public function __construct(string $code, string $phone)
    {
        $this->code = $code;
        $this->phone = $phone;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Sending SMS Job started', ['phone' => $this->phone]);
        try {
            // فرض بر این است که شناسه قالب OTP شما در sms.ir عددی مانند 372242 است
            // متد pattern به templateId تغییر کرد
            Sms::to($this->phone)
                ->templateId(254054) // شناسه قالب خود را اینجا وارد کنید
                ->addParameter('code', $this->code) // پارامترها را به صورت نام و مقدار اضافه کنید
                ->send();

            Log::info('SMS sent successfully via Job', ['phone' => $this->phone]);
        } catch (\Exception $e) {
            Log::error('SMS Job failed', [
                'phone' => $this->phone,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}