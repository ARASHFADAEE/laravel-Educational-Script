<?php

namespace App\Jobs;

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
        $apiKey = env('API_KEY_SMS_IR'); // Or use config('services.sms_ir.api_key')

        if (empty($apiKey)) {
            Log::error('SMS.IR API key is missing');
            return;
        }

        $payload = [
            'mobile' => $this->phone,
            'templateId' => 254054,
            'parameters' => [
                [
                    'name' => 'otp',
                    'value' => $this->code
                ]
            ]
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.sms.ir/v1/send/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: text/plain',
                'x-api-key: ' . $apiKey
            ],
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);


        if ($error) {
            Log::error('SMS.IR cURL error: ' . $error, [
                'phone' => $this->phone,
                'code' => $this->code
            ]);
        } elseif ($httpCode !== 200) {
            Log::warning('SMS.IR API returned non-200 status', [
                'http_code' => $httpCode,
                'response' => $response,
                'phone' => $this->phone
            ]);
        } else {
            Log::info('OTP SMS sent successfully', ['phone' => $this->phone]);
        }
    }
}
