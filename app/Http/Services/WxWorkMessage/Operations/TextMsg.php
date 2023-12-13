<?php

namespace App\Http\Services\WxWorkMessage\Operations;

use App\Http\Services\WxWorkMessage\BaseSendMsg;
use App\Http\Services\WxWorkMessage\Validation\TextMsgValidate;

class TextMsg extends BaseSendMsg
{
    /**
     * 消息类型.
     *
     * @var string
     */
    protected string $msgType = 'text';

    protected array $guardedValidate = [
        TextMsgValidate::class,
    ];

    protected array $msgExtendFields = [
        'content',
    ];
}
