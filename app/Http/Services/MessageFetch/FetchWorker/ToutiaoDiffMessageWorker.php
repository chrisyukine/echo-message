<?php

namespace App\Http\Services\MessageFetch\FetchWorker;

use App\Common\Keys\RedisKey;
use App\Common\Tools\RequestTools;
use App\Http\Services\MessageFetch\BaseMsgFetchHandle;
use Illuminate\Support\Facades\Cache;
use Mockery\Exception;

class ToutiaoDiffMessageWorker extends BaseMsgFetchHandle
{
    //todo:1.url拼装

    //todo:2.看看请求是否返回正常，否的话调整一下，有需要可以重写 fetchUrlContent 方法

    //todo:3 解析数据，需要判断是否需要推送，调用推送方法 push

    protected string $url = "https://profile.zjurl.cn/api/feed_backflow/profile_share/v1/";

    protected array $data = [
        "app_name" => "news_article",
        "category" => "profile_all",
        "visited_uid" => 3371528454945292,
        "stream_api_version" => 82,
        "request_source" => 1,
        "offset" => 0,
        "user_id" => 3371528454945292,
        "media_id" => 1782618843529216,
    ];

    private String $txt = "";

    /**
     * 发送信息.
     *
     * @return void
     *
     * @throws \Throwable
     */
    protected function fetchUrlContent()
    {
        try {
            $this->fetchResult = RequestTools::make()->request($this->httpMethod, $this->url, $this->data);
            foreach ($this->fetchResult["data"] as $key => $item) {
                if ($key > 5) break;
                $content = json_decode($item["content"], true);
                if ($content["article_type"] != 0) continue;
                if(!$content["title"] && !$content["article_url"]) continue;
                $keyword = sprintf("今日广州信息差 - %s", date("m月d日", time()));
                // 若已推送，跳出
                if (redis()->get(RedisKey::DIFF_MSG_YSF_TOUTIAO) == $keyword) break;
                //判断是否有当天线报
                if($content["title"] != $keyword) {
                    continue;
                }
                $this->txt = $content["title"] . PHP_EOL . $content["article_url"];
                redis()->set(RedisKey::DIFF_MSG_YSF_TOUTIAO, $keyword);
            }
        } catch (Exception $exception) {
            throw_if_str(true, '请求发送信息异常' . $exception->getMessage());
        }
    }

    protected function afterLogic()
    {
        if(!empty($this->txt)) $this->pushToWxMsg($this->txt);
    }
}
