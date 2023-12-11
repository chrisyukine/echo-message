<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Common\Tools\RequestTools;
use App\Http\Services\WxWorkMessage\BaseSendMsg;
use App\Http\Services\WxWorkMessage\AccessTokenService;
use App\Http\Services\WxWorkMessage\Operations\TextMsg;

class WechatAlarmTest extends TestCase
{
    public function testGetAccessToken()
    {
        $cls = new AccessTokenService();
        $res = $cls->getData();
        dump($res);
    }

    public function testFullRoat()
    {
//        $res  = BaseSendMsg::make(1)->withData(['touser' => 'tomse', 'toparty' => 'test'])->handle();
        $res  = TextMsg::with(['touser' => 'litz', 'toparty' => '', 'text' => 'tet'])->handle();
        dump($res);
    }

    public function fixCode()
    {
    }

    public function testGetUserIds()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/list_id?access_token=' . (new AccessTokenService())->getData();
        $res = RequestTools::make()->post($url);
        dump($res);
    }
}
