<?php

namespace App\Modules\Sms;

use Exception;
use Illuminate\Support\Facades\Log;

class SmsManager
{
    protected string $apiKey;
    protected ?string $to = null;
    protected ?int $templateId = null;
    protected array $parameters = [];

    public function __construct()
    {
        // کلید API شما در sms.ir در اینجا خوانده می‌شود
        // بهتر است در فایل config/sms.php مقدار key را اضافه کنید
        $this->apiKey = config('sms.api_key');
    }

    /**
     * تنظیم شماره مقصد
     */
    public function to(string $phone): self
    {
        $this->to = $phone;
        return $this;
    }

    /**
     * تنظیم شناسه قالب (Template ID)
     * در SMS.ir به جای pattern از templateId استفاده می‌شود
     */
    public function templateId(int $id): self
    {
        $this->templateId = $id;
        return $this;
    }

    /**
     * افزودن پارامترهای قالب
     * این روش اجازه می‌دهد هر تعداد پارامتر به صورت زنجیره‌ای اضافه شود
     * مثال: ->addParameter('code', '1234')->addParameter('name', 'Ali')
     */
    public function addParameter(string $name, $value): self
    {
        $this->parameters[$name] = $value;
        return $this;
    }

    /**
     * ارسال پیام
     */
    public function send(): mixed
    {
        // اعتبارسنجی اولیه
        if (!$this->to || !$this->templateId) {
            Log::error('SMS Send Failed: Missing phone or templateId', [
                'phone' => $this->to,
                'templateId' => $this->templateId
            ]);
            return false;
        }

        $url = 'https://api.sms.ir/v1/send/verify';
        
        // ساخت آرایه پارامترها به فرمت مورد نیاز SMS.ir
        // فرمت: [{"name": "PARAMETER1", "value": "value1"}, ...]
        $formattedParams = [];
        foreach ($this->parameters as $key => $value) {
            $formattedParams[] = [
                'name' => $key,
                'value' => $value
            ];
        }

        $payload = [
            'mobile'      => $this->to,
            'templateId'  => $this->templateId,
            'parameters'  => $formattedParams
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30, // افزایش زمان تاخیر برای پایداری بیشتر
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Accept: text/plain',
                "x-api-key: {$this->apiKey}"
            ],
        ]);

        try {
            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error = curl_error($curl);
            curl_close($curl);

            if ($error) {
                throw new Exception("cURL Error: " . $error);
            }

            // بررسی کد وضعیت HTTP
            if ($httpCode < 200 || $httpCode >= 300) {
                throw new Exception("HTTP Error: {$httpCode} - Response: {$response}");
            }

            // بازگشت پاسخ (معمولاً یک عدد است: 1 برای موفقیت)
            return trim($response);

        } catch (Exception $e) {
            Log::error('SMS Send Failed', [
                'phone' => $this->to,
                'templateId' => $this->templateId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}