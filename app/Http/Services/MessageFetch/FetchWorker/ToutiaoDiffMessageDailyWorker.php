<?php

namespace App\Http\Services\MessageFetch\FetchWorker;

use Mockery\Exception;
use App\Common\Keys\RedisKey;
use App\Common\Tools\RequestTools;

class ToutiaoDiffMessageDailyWorker extends ToutiaoDiffMessageWorker
{
    protected array $data = [
        'app_name'           => 'news_article',
        'category'           => 'profile_all',
        'visited_uid'        => 198324574754471,
        'stream_api_version' => 82,
        'request_source'     => 1,
        'offset'             => 0,
        'user_id'            => 198324574754471,
        'media_id'           => 1764018282691598,
    ];

    private String $txt = '';

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
            foreach ($this->fetchResult['data'] as $key => $item) {
                if ($key > 5) {
                    break;
                }
                $content = json_decode($item['content'], true);
                if (0 != $content['article_type'] || empty($content['share'])) {
                    continue;
                }
                if (preg_match('/星期/', $content['share']['share_title'])) {
                    preg_match('/\/(\d+)\//', $content['share']['share_url'], $mat);

                    // 若已推送，跳出
                    if ($mat[1] . '_id' == redis()->get(RedisKey::DIFF_MSG_YSF_TOUTIAO_DAILY)) {
                        break;
                    }
                    $this->txt = str_replace(['心跳回忆EMN：', '#挑战30天在头条写日记#'], '', $content['share']['share_title'] . PHP_EOL . $content['share']['share_url']);

                    redis()->set(RedisKey::DIFF_MSG_YSF_TOUTIAO_DAILY, $mat[1] . '_id');
                }
            }
        } catch (Exception $exception) {
            throw_if_str(true, '请求发送信息异常' . $exception->getMessage());
        }
    }

    protected function afterLogic()
    {
        if (!empty($this->txt)) {
            $this->pushToWxMsg($this->txt);
        }
    }
}
