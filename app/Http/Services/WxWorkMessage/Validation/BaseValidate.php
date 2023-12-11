<?php

namespace App\Http\Services\WxWorkMessage\Validation;

use Illuminate\Support\Facades\Validator;
use App\Http\Services\WxWorkMessage\BaseSendMsg;
use App\Http\Services\WxWorkMessage\AbstractSendMsg;
use App\Http\Services\Interfaces\WxWorkAlarmValidationInterface;

class BaseValidate implements WxWorkAlarmValidationInterface
{
    public function __construct($data)
    {
        //必须字段校验
        $validator = Validator::make($data, [
            BaseSendMsg::MSG_REQUIRED_FIELDS['TO_USER']                    => 'required_without_all:toparty,totag',
            BaseSendMsg::MSG_REQUIRED_FIELDS['TO_PARTY']                   => 'required_without_all:touser,totag',
            BaseSendMsg::MSG_REQUIRED_FIELDS['TO_TAG']                     => 'required_without_all:touser,toparty',
            BaseSendMsg::MSG_REQUIRED_FIELDS['AGENTID']                    => 'required',
            BaseSendMsg::MSG_REQUIRED_FIELDS['SAFE']                       => 'int',
            BaseSendMsg::MSG_REQUIRED_FIELDS['ENABLE_ID_TRAN']             => 'int',
            BaseSendMsg::MSG_REQUIRED_FIELDS['ENABLE_DUPLICATE_CHECK']     => 'int',
            BaseSendMsg::MSG_REQUIRED_FIELDS['DUPLICATE_CHECK_INTERVAL']   => 'int',
        ]);

        //字段格式校验
        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            throw_if_str(true, '字段检验异常:' . $errors);
            throw new \Exception($errors);
        }
    }

    /**
     * @param AbstractSendMsg $pointer
     */
    public function validate(AbstractSendMsg $pointer)
    {
    }
}
