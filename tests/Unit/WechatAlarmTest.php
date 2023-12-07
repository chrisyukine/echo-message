<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Services\WxWorkAccessToken;

class WechatAlarmTest extends TestCase
{
    public function testGetAccessToken()
    {
        $cls = new WxWorkAccessToken();
        $res = $cls->getData();
        dump($res);
    }
}
