<?php

namespace Tests\Unit;

use App\Http\Services\WxWorkAccessToken;
use Tests\TestCase;

class WechatAlarmTest extends TestCase
{

    public function testGetAccessToken()
    {
        $cls = new WxWorkAccessToken();
        $cls->getResult();
    }
}
