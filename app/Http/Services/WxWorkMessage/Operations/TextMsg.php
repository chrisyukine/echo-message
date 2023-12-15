<?php

namespace App\Http\Services\WxWorkMessage\Operations;

use App\Http\Services\WxWorkMessage\BaseSendMsgService;
use App\Http\Services\WxWorkMessage\Validation\TextMsgValidate;

class TextMsg extends BaseSendMsgService
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
        'text',
    ];

    protected function msgData()
    {
        $this->data['text'] = ['content' => $this->data['text']];
    }
}
