<?php

namespace App\Http\Controllers;

use App\Http\Services\MessageFetch\FetchWorker\ToutiaoFetchMsgWorker;
use Illuminate\Http\Request;
use App\Http\Services\MessageFetch\FetchWorker\ToutiaoDiffMessageWorker;

class DailyPushController extends Controller
{
    /**
     * @see https://profile.zjurl.cn/rogue/ugc/profile/?user_id=3371528454945292
     * 每日信息差 ：叶师傅头条信息差
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toutiaoDiffMessage(Request $request)
    {
        $res = (new ToutiaoDiffMessageWorker())->handle();
        return response()->json(['push_result' => $res], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
