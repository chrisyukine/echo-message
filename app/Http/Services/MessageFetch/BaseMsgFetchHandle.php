<?php

namespace App\Http\Services\MessageFetch;

use Mockery\Exception;
use App\Common\Tools\RequestTools;
use Illuminate\Support\Facades\Log;
use App\Http\Services\WxWorkMessage\Operations\TextMsg;

class BaseMsgFetchHandle
{
    protected string $url        = 'httpsss';
    protected string $httpMethod = 'GET';
    protected array $fetchResult = [];
    protected array $data        = [];

    /**
     * 主流程.
     *
     * @return bool
     *
     * @throws \Throwable
     */
    public function handle()
    {
        //设置默认数据
        $this->init();

        //发送请求
        $this->fetchUrlContent();

        //内容拉取后拼装以及推送等操作
        $this->afterLogic();

        return true;
    }

    /**
     * ******************************主流程调用到的方法****************************************.
     */

    /**
     * 初始化方法，其它初始化都需继承，用于拼装默认参数.
     *
     * @return void
     */
    protected function init()
    {
    }

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
        } catch (Exception $exception) {
            throw_if_str(true, '请求发送信息异常' . $exception->getMessage());
        }
    }

    /**
     * 后续操作.
     *
     * @return void
     */
    protected function afterLogic()
    {
    }

    /**
     * 内部推送微信内容方法.
     *
     * @param $content
     *
     * @return void
     *
     * @throws \Throwable
     */
    protected function pushToWxMsg($content)
    {
        Log::info('push ok', ['text' => $content]);

        TextMsg::with(['text' => $content, 'notice_type' => 'daily_toutiao'])->handle();
    }

    /**
     * 获取常量（允许使用 xxx->getXXX()方法查询返回数据）.
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (0 === strpos($name, 'get')) {
            $propertyName = lcfirst(substr($name, 3));
            if (property_exists($this, $propertyName)) {
                return $this->$propertyName;
            }
        }
        throw new Exception("Method {$name} does not exist");
    }
}
