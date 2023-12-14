<?php

namespace App\Http\Services\MessageFetch\FetchWorker;

use App\Http\Services\MessageFetch\BaseMsgFetchHandle;

class DailyDiffMessageWorker extends BaseMsgFetchHandle
{
    //todo:1.url拼装

    //todo:2.看看请求是否返回正常，否的话调整一下，有需要可以重写 fetchUrlContent 方法

    //todo:3 解析数据，需要判断是否需要推送，调用推送方法 push
}
