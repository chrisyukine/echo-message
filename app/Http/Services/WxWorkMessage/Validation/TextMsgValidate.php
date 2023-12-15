<?php

namespace App\Http\Services\WxWorkMessage\Validation;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\WxWorkMessage\AbstractSendMsgService;
use App\Http\Services\Interfaces\WxWorkAlarmValidationInterface;

class TextMsgValidate extends BaseValidate implements WxWorkAlarmValidationInterface
{
    /**
     * @param AbstractSendMsgService $pointer
     */
    public function validate(AbstractSendMsgService $pointer)
    {
        //必须字段校验
        $validator = Validator::make($pointer->data, [
            'msgtype' => [Rule::in(['text'])],
            'text'    => 'required|array',
        ]);

        //字段格式校验
        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            throw_if_str(true, '字段检验异常' . $errors);
            throw new \Exception($errors);
        }
    }
}
