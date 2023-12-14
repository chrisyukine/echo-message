<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Common\Tools\RequestTools;
use Illuminate\Support\Facades\Log;
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

    public function testFixCode()
    {
        Log::info('test_Test', [1235413245123]);
    }

    public function testGetUserIds()
    {
//        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/list_id?access_token=' . (new AccessTokenService())->getData();
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/list_id';
        $res = RequestTools::make()->request('post', $url, ['name' => '111id', 'id' => '2202']);
        dump($res->body());
    }
}
