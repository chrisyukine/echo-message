<?php

namespace App\Http\Services\WxWorkMessage\Operations;

use Illuminate\Support\Arr;
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

    /**
     * 初始化数据.
     *
     * @return void
     */
    protected function init()
    {
        if (isset($this->data['notice_type'])) {
            $this->noticeType = Arr::get(self::MSG_TYPE_APP_CONFIG_MAPPING, $this->data['notice_type'], $this->noticeType);
        }

        parent::init();
    }

    protected function msgData()
    {
        $this->data['text'] = ['content' => $this->data['text']];
    }
}
