<?php

return [

    //验证码存储
    'redis_connection' => 'sms',
    'captcha_key' => 'captcha',
    'captcha_expire' => env('CAPTCHA_EXPIRE', 300),

    //验证码限制
    'captcha_limit_key' => 'captcha_limit',
    'captcha_limit_times' => env('CAPTCHA_LIMIT_TIMES', 5),
    'captcha_limit_expire' => env('CAPTCHA_LIMIT_EXPIRE', 3600),

    //多国家发送
    'multi_country' => false,
];
