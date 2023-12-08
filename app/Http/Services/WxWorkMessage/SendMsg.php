<?php

namespace App\Http\Services\WxWorkMessage;

use Mockery\Exception;
use App\Common\Tools\RequestTools;

class SendMsg extends AbstractSendMsg
{
    protected array $guardedValidate = [];

    public function handle()
    {
        //初始化数据
        $this->init();

        //校验数据
        $this->validate();

        //发送请求
        $this->sendMsg();
    }

    /**
     * ******************************主流程调用到的方法****************************************.
     */
    protected function init()
    {
    }

    /**
     * 参数校验（返回当前对象，支持链式调用）.
     *
     * @return $this
     */
    protected function validate(): self
    {
        foreach ($this->guardedValidate as $item) {
            $item::validate($this);
        }

        return $this;
    }

    /**
     * 发送信息.
     *
     * @return void
     *
     * @throws \Throwable
     */
    protected function sendMsg()
    {
        try {
            $url = sprintf(config('wechat.wx_work.msg_host'), (new AccessTokenService())->getData());
            dump($url);
            dump($this->data);
//            $res = RequestTools::make()->post($url, $this->data);
        } catch (Exception $exception) {
            throw_if_str(true, '请求发送信息异常' . $exception->getMessage());
        }
    }
}
