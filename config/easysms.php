<?php
return [
    //HTTP请求的超时时间(秒)
    'timeout'=>5.0,
    // 默认发送配置
    'default' => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => [
             'aliyun',
        ],
    ],
     // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'aliyun' => [
            'access_key_id' => env('ALIYUN_KEY_ID'),
            'access_key_secret' => env('ALIYUN_KEY_SECRET'),
            'sign_name' =>env('ALIYUN_SIGN_NAME'),
        ],
        //...
    ],
];
/*
try {
    $sms->send(13159251992, [
         'content'  => '您的验证码为: 6379',
         'template' => 'SMS_139585064',
        'data' => [
          'code' => 6379
        ],
    ]);
} catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
    $message = $exception->getException('aliyun')->getMessage();
    dd($message);
}
*/