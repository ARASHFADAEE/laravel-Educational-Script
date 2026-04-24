<?php

namespace App\Jobs;

use App\Modules\Sms\Facades\Sms;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendSuccessPaymentSmsJob implements ShouldQueue
{
    use Queueable;

    protected string $phone;
    protected string $client_name;
    protected string $course_name;


    

    /**
     * Create a new job instance.
     */
    public function __construct(string $phone, string $course_name, string $client_name)
    {
        $this->phone = $phone;
        $this->course_name = $course_name;
        $this->client_name = $client_name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Sending SMS Payment Job started', ['phone' => $this->phone]);

        try {
            // استفاده از متد templateId به جای pattern
            // استفاده از addParameter برای هر متغیر به صورت جداگانه
            Sms::to($this->phone)
                ->templateId(411699) // شناسه قالب پرداخت در پنل sms.ir
                ->addParameter('client_name', $this->client_name) // نام پارامتر باید دقیقاً همانی باشد که در قالب sms.ir تعریف شده
                ->addParameter('course_name', $this->course_name)
                ->send();

            Log::info('SMS sent successfully via Job', ['phone' => $this->phone]);
        } catch (\Exception $e) {
            Log::error('SMS Payment Job failed', [
                'phone' => $this->phone,
                'error' => $e->getMessage()
            ]);
            // اگر می‌خواهید در صورت خطا، جاب دوباره تلاش کند، خط زیر را نگه دارید.
            // اگر نمی‌خواهید retry شود، throw $e را حذف کنید.
            throw $e;
        }
    }
}