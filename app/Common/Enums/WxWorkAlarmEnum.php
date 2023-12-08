<?php

declare(strict_types=1);

namespace App\Common\Enums;

use App\Http\Services\WxWorkMessage\Operations\TextMsg;

class WxWorkAlarmEnum
{
    const MSG_TYPE_TEXT        = 1; // 文本类型
    const MSG_TYPE_PIC         = 2; // 图片
    const MSG_TYPE_VOICE       = 3; // 语音消息
    const MSG_TYPE_VIDEO       = 4; // 视频消息
    const MSG_TYPE_FILE        = 5; // 文件消息
    const MSG_TYPE_TEXT_CARD   = 6; // 文本卡片消息
    const MSG_TYPE_NEWS        = 7; // 图文消息
    const MSG_TYPE_MP_NEWS     = 8; // 图文消息（mpnews）唯一的差异是图文内容存储在企业微信。
    const MSG_TYPE_MARKDOWN    = 9; // markdown消息
    const MSG_TYPE_MINI_NOTICE = 10; // 小程序通知消息

    const CLS_MAPPING = [
        self::MSG_TYPE_TEXT => TextMsg::class,
    ];
}
