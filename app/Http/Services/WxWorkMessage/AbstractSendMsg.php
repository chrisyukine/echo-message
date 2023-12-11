<?php

namespace App\Http\Services\WxWorkMessage;

use App\Http\Services\Interfaces\WxWorkAlarmValidationInterface;

class AbstractSendMsg
{
    /**
     * 校验类.
     *
     * @var WxWorkAlarmValidationInterface[]
     */
    protected array $guardedValidate = [];

    /**
     * @var array
     */
    public array $data;

    /**
     * 类实例化.
     *
     * @param static
     *
     * @return AbstractSendMsg
     *
     * @throws \Throwable
     *
     * @author litongzhi 2022/5/13 11:40
     */
    public static function with($data)
    {
        return tap(new static(), function ($that) use ($data) {
            $that->data = $data;
        });
    }

    /**
     * 主流程.
     *
     * @return mixed
     */
    public function handle()
    {
    }
}
