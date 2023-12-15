<?php

namespace App\Http\Services\Interfaces;

use App\Http\Services\WxWorkMessage\AbstractSendMsgService;

interface WxWorkAlarmValidationInterface
{
    public function validate(AbstractSendMsgService $pointer);
}
