<?php

namespace App\Jobs;
use App\Modules\Sms\Facades\Sms;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;


class SendSuccsesPaymentSmsJob implements ShouldQueue
{
    use Queueable;


    protected string $phone ;
    protected string $client_name ;
    protected string $course_name ;



    /**
     * Create a new job instance.
     */
    public function __construct($phone , $course_name ,$client_name )
    {
        //

        $this->phone = $phone;
        $this->course_name = $course_name;
        $this->client_name = $client_name;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //

        Log::info('Sending SMS Payment Job started', ['phone' => $this->phone]);



        try {
            Sms::to($this->phone)
                ->pattern('411699')
                ->send([$this->client_name , $this->course_name]);

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
