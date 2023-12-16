<?php

return [
    'wx_work' => [
        // 请求的路径
        'host'            => env('WX_WORK_APP_HOST', 'https://qyapi.weixin.qq.com'),  //
        // token请求地址
        'token_host'      => env('WX_WORK_APP_ACCESS_TOKEN_HOST', 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=%s&corpsecret=%s'),
        // 发送应用消息
        'msg_host'        => env('WX_WORK_APP_SEND_MSG_HOST', 'https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=%s&debug=1'),
        'app'             => [
            'id'            => env('WX_WORK_CORPID', ''),
            'push_secret'   => env('WX_WORK_DAILY_PUSH_SECRET', ''),
            'push_agent_id' => env('WX_WORK_DAILY_PUSH_AGENTID', ''),
        ],
        'app_warning'     => [
            'id'            => env('WX_WORK_CORPID', ''),
            'push_secret'   => env('WX_WORK_WARNING_DAILY_PUSH_SECRET', ''),
            'push_agent_id' => env('WX_WORK_WARNING_DAILY_PUSH_AGENTID', ''),
        ],
    ],
];
