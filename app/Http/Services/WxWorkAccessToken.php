<?php

namespace App\Http\Services;

use App\Common\Keys\RedisKey;
use App\Common\Tools\RequestTools;
use Illuminate\Support\Facades\Redis;

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

    /**
     * 获取token
     *
     * @return mixed
     */
    public function getData()
    {
        dd('test');
        $res = RequestTools::make()->get($this->getUrl());
        $cacheRes = redis()->get(RedisKey::WX_WORK_ALARM_ACCESS_TOKEN);
        if ($cacheRes) {
            $res = json_decode($cacheRes, true);
        } else {
            dd('test_test');
            $res1 = redis()->set(RedisKey::WX_WORK_ALARM_ACCESS_TOKEN, json_encode($res, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
            redis()->expire(RedisKey::WX_WORK_ALARM_ACCESS_TOKEN, 7200);
        }
        return $res['access_token'];
    }
}
