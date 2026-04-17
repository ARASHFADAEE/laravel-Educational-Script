<?php

namespace App\Modules\Sms;

use SoapClient;
use Exception;

class SmsManager
{
    protected string $username;
    protected string $password;
    protected ?string $to = null;
    protected ?string $pattern = null;

    public function __construct()
    {
        $this->username = config('sms.username');
        $this->password = config('sms.password');
    }

    public function to(string $phone): self
    {
        $this->to = $phone;
        return $this;
    }

    public function pattern(string $pattern): self
    {
        $this->pattern = $pattern;
        return $this;
    }

    public function send(array $args = []): mixed
    {
        ini_set("soap.wsdl_cache_enabled", "0");

        try {
            $client = new SoapClient("http://api.payamak-panel.com/post/Send.asmx?wsdl", [
                "encoding" => "UTF-8",
            ]);

            $text = "@{$this->pattern}@" . implode(';', $args);

            $data = [
                "username" => $this->username,
                "password" => $this->password,
                "text"     => $text,
                "to"       => $this->to,
            ];

            return $client->SendByBaseNumber3($data)->SendByBaseNumber3Result;

        } catch (Exception $e) {
            report($e);
            return false;
        }
    }
}