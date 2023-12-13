<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\WxWorkMessage\Operations\TextMsg;

class WxWorkMsgController extends Controller
{
    public function sendMsg(Request $request)
    {
        $this->validate(
            $request,
            [
                'text' => 'required|string',
            ],
            [
                'text.*' => '内容不能为空',
            ]
        );

        $res  = TextMsg::with($request->all())->handle();

        response()->json([$res], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
