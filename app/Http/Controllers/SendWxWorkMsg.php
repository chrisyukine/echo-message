<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\WxWorkMessage\Operations\TextMsg;

class SendWxWorkMsg extends Controller
{
    public function sendMsg(Request $request)
    {
        $this->validate(
            $request,
            [
                'ids' => 'required|array',
            ],
            [
                'ids.*' => '账单ID错误',
            ]
        );

        $res  = TextMsg::with($request->all())->handle();

        response()->json([$res], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
