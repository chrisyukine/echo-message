<?php

namespace App\Http\Services\WxWorkMessage;

use function redis;
use Illuminate\Support\Arr;
use App\Common\Keys\RedisKey;
use App\Common\Tools\RequestTools;

class AccessTokenService
{
    /**
     * 获取请求access_token地址
     *
     * @param string $copId
     * @param string $secret
     *
     * @return string
     */
    private function getUrl(string $copId = '', string $secret = ''): string
    {
        return sprintf(config('wechat.wx_work.token_host'), $copId ?: config('wechat.wx_work.app.id'), $secret ?: config('wechat.wx_work.app.push_secret'));
    }

    /**
     * 获取token.
     *
     * @return mixed
     */
    public function getData()
    {
        $cacheRes = redis()->get(RedisKey::WX_WORK_ALARM_ACCESS_TOKEN);
        if ($cacheRes) {
            $res = json_decode($cacheRes, true);
        } else {
            $res = RequestTools::make()->get($this->getUrl());
            redis()->set(RedisKey::WX_WORK_ALARM_ACCESS_TOKEN, json_encode($res, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            redis()->expire(RedisKey::WX_WORK_ALARM_ACCESS_TOKEN, 7200);
        }

        return Arr::get($res, 'access_token');
    }
}
