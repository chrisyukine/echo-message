<?php

namespace App\Http\Services\WxWorkMessage;

use Illuminate\Support\Arr;
use App\Common\Enums\WxWorkAlarmEnum;
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
    protected array $data;

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
    public static function make($alarmEnum)
    {
        $className = Arr::get(WxWorkAlarmEnum::CLS_MAPPING, $alarmEnum);
        throw_if_str(!$className, '暂无匹配数据处理类');

        return app($className);
    }

    /**
     * 主流程.
     *
     * @return mixed
     */
    public function handle()
    {
        return 111;
    }

    /**
     * 携带的参数.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withData(array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
