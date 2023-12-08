<?php

namespace App\Http\Services\WxWorkMessage\Validation;

use App\Http\Services\Interfaces\WxWorkAlarmValidationInterface;
use App\Http\Services\WxWorkMessage\AbstractSendMsg;
use App\Http\Services\WxWorkMessage\Operations\TextMsg;

class TextMsgValidate implements WxWorkAlarmValidationInterface
{
    protected $pointer;

    /**
     * @param AbstractSendMsg $pointer
     */
    public static function validate(AbstractSendMsg $pointer)
    {
        //必须字段校验

        //字段格式校验


    }

}
