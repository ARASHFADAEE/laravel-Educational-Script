# 📩 Laravel SMS Module

A clean and modular SMS service implementation for Laravel using
**Service Providers** and **Facades**.


```bash

app/
└── Modules/
    └── Sms/
        ├── Facades/
        │   └── Sms.php
        ├── Services/
        │   └── SmsService.php
        ├── SmsServiceProvider.php
        └── README.md   (optional, module-level docs)

bootstrap/
└── services/
    └── providers.php

config/
└── sms.php
```

---

## ✨ Features

- Modular architecture (App Modules)
- Laravel Service Provider support
- Facade-based API
- Environment-based configuration
- Easy to extend or replace SMS providers

---

## 📦 Installation

### 1. Create Configuration File

Create the SMS configuration file:

```bash
config/sms.php


<?php

return [
    'username' => env('SMS_USERNAME'),
    'password' => env('SMS_PASSWORD'),
];


```


### 2. Add your credentials to the .env file:

```bash

SMS_USERNAME=your_sms_username
SMS_PASSWORD=your_sms_password


```


### 3. Register Service Provider
Register the SMS service provider in Laravel.

```bash
bootstrap/services/providers.php


<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Modules\Sms\SmsServiceProvider::class,
];



```

###🚀 Usage
Import the Facade

```bash

use App\Modules\Sms\Facades\Sms;

```

### Send SMS Example


```bash

Sms::to('09140065379')
            ->pattern('PatternId')
            ->send(['arg1','arg2','arg3']);
```
