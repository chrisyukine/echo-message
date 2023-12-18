<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\MessageFetch\FetchWorker\ToutiaoDiffMessageWorker;
use App\Http\Services\MessageFetch\FetchWorker\ToutiaoDiffMessageDailyWorker;

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

    /**
     * @see https://profile.zjurl.cn/rogue/ugc/profile/?user_id=198324574754471&media_id=1764018282691598&request_source=1
     * 每日提醒
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function toutiaoDiffMessageDaily(Request $request)
    {
        $res = (new ToutiaoDiffMessageDailyWorker())->handle();

        return response()->json(['push_result' => $res], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
