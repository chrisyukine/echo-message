<?php

namespace App\Http\Services;

use App\Common\Tools\RequestTools;

class WxWorkAccessToken
{
    /**
     * 获取请求access_token地址
     *
     * @param string $copId
     * @param string $secret
     * @return string
     */
    private function getUrl(string $copId = '', string $secret = ''): string
    {
        return sprintf(config('wechat_message.wx_work.token_host'), $copId?:config('wechat_message.wx_work.app.id'), $secret?:config('wechat_message.wx_work.app.push_secret'));
    }

    public function getResult()
    {
        $res = RequestTools::make()->get($this->getUrl());

    }
}
