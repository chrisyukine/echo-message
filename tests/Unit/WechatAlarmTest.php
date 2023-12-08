<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Services\WxWorkMessage\SendMsg;
use App\Http\Services\WxWorkMessage\AccessTokenService;

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
        $res  = SendMsg::make(1)->withData(['touser' => 'tomse', 'toparty' => 'test'])->handle();
        dump($res);
    }

    public function fixCode()
    {
    }
}
