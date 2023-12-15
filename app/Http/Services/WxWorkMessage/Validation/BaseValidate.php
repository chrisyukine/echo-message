<?php

namespace App\Http\Services\WxWorkMessage\Validation;

use Illuminate\Support\Facades\Validator;
use App\Http\Services\WxWorkMessage\BaseSendMsgService;
use App\Http\Services\WxWorkMessage\AbstractSendMsgService;
use App\Http\Services\Interfaces\WxWorkAlarmValidationInterface;

class BaseValidate implements WxWorkAlarmValidationInterface
{
    public function __construct($data)
    {
        //必须字段校验
        $validator = Validator::make($data, [
            BaseSendMsgService::MSG_REQUIRED_FIELDS['TO_USER']                    => 'required_without_all:toparty,totag',
            BaseSendMsgService::MSG_REQUIRED_FIELDS['TO_PARTY']                   => 'required_without_all:touser,totag',
            BaseSendMsgService::MSG_REQUIRED_FIELDS['TO_TAG']                     => 'required_without_all:touser,toparty',
            BaseSendMsgService::MSG_REQUIRED_FIELDS['AGENTID']                    => 'required',
            BaseSendMsgService::MSG_REQUIRED_FIELDS['SAFE']                       => 'int',
            BaseSendMsgService::MSG_REQUIRED_FIELDS['ENABLE_ID_TRAN']             => 'int',
            BaseSendMsgService::MSG_REQUIRED_FIELDS['ENABLE_DUPLICATE_CHECK']     => 'int',
            BaseSendMsgService::MSG_REQUIRED_FIELDS['DUPLICATE_CHECK_INTERVAL']   => 'int',
        ]);

        //字段格式校验
        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            throw_if_str(true, '字段检验异常:' . $errors);
            throw new \Exception($errors);
        }
    }

    /**
     * @param AbstractSendMsgService $pointer
     */
    public function validate(AbstractSendMsgService $pointer)
    {
    }
}
