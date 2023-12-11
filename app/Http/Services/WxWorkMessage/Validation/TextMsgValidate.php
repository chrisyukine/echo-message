<?php

namespace App\Http\Services\WxWorkMessage\Validation;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\WxWorkMessage\AbstractSendMsg;
use App\Http\Services\Interfaces\WxWorkAlarmValidationInterface;

class TextMsgValidate extends BaseValidate implements WxWorkAlarmValidationInterface
{
    /**
     * @param AbstractSendMsg $pointer
     */
    public function validate(AbstractSendMsg $pointer)
    {
        //必须字段校验
        $validator = Validator::make($pointer->data, [
            'msgtype' => [Rule::in(['text'])],
            'text'    => 'required',
        ]);

        //字段格式校验
        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            throw_if_str(true, '字段检验异常' . $errors);
            throw new \Exception($errors);
        }
    }
}
