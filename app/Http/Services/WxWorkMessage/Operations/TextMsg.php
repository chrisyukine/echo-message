<?php
namespace App\Http\Services\WxWorkMessage\Operations;


use App\Http\Services\WxWorkMessage\SendMsg;

class TextMsg extends SendMsg
{
    protected function init()
    {
        $this->data['test'] = [];
    }
}
