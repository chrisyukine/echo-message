<?php

namespace App\Http\Services\WxWorkMessage;

use function redis;
use Illuminate\Support\Arr;
use App\Common\Keys\RedisKey;
use App\Common\Tools\RequestTools;

class AccessTokenService
{
    /**
     * 企业微信提醒配置.
     *
     * @var array
     */
    private $wxWorkNoticeConfig = [];
    private $noticeType         = '';

    public function __construct($noticeType = 'app')
    {
        $this->noticeType         = $noticeType;
        $this->wxWorkNoticeConfig = config('wechat.wx_work.' . $this->noticeType);
    }

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
        return sprintf(
            config('wechat.wx_work.token_host'),
            $copId ?: Arr::get($this->wxWorkNoticeConfig, 'id'),
            $secret ?: Arr::get($this->wxWorkNoticeConfig, 'push_secret')
        );
    }

    /**
     * 获取token.
     *
     * @return mixed
     */
    public function getData()
    {
        $cacheKey = RedisKey::WX_WORK_ALARM_ACCESS_TOKEN . $this->noticeType;

        $cacheRes = redis()->get($cacheKey);
        if ($cacheRes) {
            $res = json_decode($cacheRes, true);
        } else {
            $res = RequestTools::make()->request('get', $this->getUrl());
            redis()->set($cacheKey, json_encode($res, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            redis()->expire($cacheKey, 7200);
        }

        return Arr::get($res, 'access_token');
    }
}
