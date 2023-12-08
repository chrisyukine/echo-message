<?php

namespace App\Http\Services\Interfaces;

use App\Http\Services\WxWorkMessage\AbstractSendMsg;

interface WxWorkAlarmValidationInterface
{
    public static function validate(AbstractSendMsg $pointer);
}