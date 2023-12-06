<?php

return [
    'wx_work' => [
        // 请求的路径
        'host'            => env('WX_WORK_APP_HOST', 'https://qyapi.weixin.qq.com'),  //
        // token请求地址
        'token_host'      => env('WX_WORK_APP_ACCESS_TOKEN_HOST', 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=%s&corpsecret=%s'), //
        'app'             => [
            'id'            => env('WX_WORK_CORPID', env('WX_WORK_CORPID')),
            'push_secret'   => env('WX_WORK_DAILY_PUSH_SECRET', env('WX_WORK_DAILY_PUSH_SECRET')),
        ]
    ]
];
