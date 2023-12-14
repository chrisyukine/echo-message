<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\MessageFetch\FetchWorker\DailyDiffMessageWorker;

class DailyPushController extends Controller
{
    /**
     * @see https://profile.zjurl.cn/rogue/ugc/profile/?user_id=3371528454945292
     * 每日信息差 ：
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dailyDiffMessage(Request $request)
    {
        $res = (new DailyDiffMessageWorker())->handle();

        return response()->json(['send_result' => $res], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
