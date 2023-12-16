<?php

namespace App\Http\Services\WxWorkMessage;

use Mockery\Exception;
use Illuminate\Support\Arr;
use App\Common\Tools\RequestTools;
use Illuminate\Support\Facades\Log;

class BaseSendMsgService extends AbstractSendMsgService
{
    //【参数说明】
    const DEFAULT_CONFIG_TO_USER    = '@all'; // 对应-touser  指定接收消息的成员，成员ID列表（多个接收者用‘|’分隔，最多支持1000个）。
    const DEFAULT_CONFIG_TO_PARTY   = ''; // 对应-toparty  指定接收消息的部门，部门ID列表，多个接收者用‘|’分隔，最多支持100个。
    const DEFAULT_CONFIG_TO_TAG     = ''; // 对应-totag  指定接收消息的标签，标签ID列表，多个接收者用‘|’分隔，最多支持100个。
    const DEFAULT_CONFIG_SAFE       = 0; // 对应-safe  表示是否是保密消息，0表示可对外分享，1表示不能分享且内容显示水印，默认为0
    const DEFAULT_CONFIG_TRAN       = 0; // 对应-enable_id_trans  表示是否开启id转译，0表示否，1表示是，默认0。仅第三方应用需要用到，企业自建应用可以忽略。
    const DEFAULT_CONFIG_DUPLICATE  = 0; // 对应-enable_duplicate_check  表示是否开启重复消息检查，0表示否，1表示是，默认0
    const DEFAULT_CONFIG_CHECK_TIME = 1800; // 对应-duplicate_check_interval  表示是否重复消息检查的时间间隔，默认1800s，最大不超过4小时

    const MSG_REQUIRED_FIELDS = [
        'TO_USER'                   => 'touser',
        'TO_PARTY'                  => 'toparty',
        'TO_TAG'                    => 'totag',
        'AGENTID'                   => 'agentid',
        'SAFE'                      => 'safe',
        'ENABLE_ID_TRAN'            => 'enable_id_trans',
        'ENABLE_DUPLICATE_CHECK'    => 'enable_duplicate_check',
        'DUPLICATE_CHECK_INTERVAL'  => 'duplicate_check_interval',
        'MSG_TYPE'                  => 'msgtype',
    ];

    protected string $msgType        = '';
    protected string $noticeType     = 'app';
    protected array $guardedValidate = [];
    protected array $msgExtendFields = [];

    public function handle()
    {
        //设置默认数据
        $this->init();

        //额外扩展数据（针对于不同模板的扩展方法）
        $this->msgData();

        //校验数据
        $this->validate();

        //发送请求
        $this->sendMsg();

        return true;
    }

    /**
     * ******************************主流程调用到的方法****************************************.
     */

    /**
     * 初始化方法，其它初始化都需继承，用于拼装默认参数.
     *
     * @return void
     */
    protected function init()
    {
        $defaultConfig = [
            'touser'                   => self::DEFAULT_CONFIG_TO_USER,
            'toparty'                  => self::DEFAULT_CONFIG_TO_PARTY,
            'totag'                    => self::DEFAULT_CONFIG_TO_TAG,
            'agentid'                  => Arr::get(config('wechat.wx_work.' . $this->noticeType), 'push_agent_id'),
            'msgtype'                  => $this->msgType,
            'safe'                     => self::DEFAULT_CONFIG_SAFE,
            'enable_id_trans'          => self::DEFAULT_CONFIG_TRAN,
            'enable_duplicate_check'   => self::DEFAULT_CONFIG_DUPLICATE,
            'duplicate_check_interval' => self::DEFAULT_CONFIG_CHECK_TIME,
        ];

        //合并基础数据
        $this->data = array_merge($defaultConfig, $this->data);

        //过滤数据
        $this->data = Arr::only($this->data, array_merge(self::MSG_REQUIRED_FIELDS, $this->msgExtendFields));
    }

    /**
     * 构建需要扩展的信息数据.
     *
     * @return void
     */
    protected function msgData()
    {
    }

    /**
     * 参数校验（返回当前对象，支持链式调用）.
     *
     * @return $this
     */
    protected function validate(): self
    {
        foreach ($this->guardedValidate as $item) {
            (new $item($this->data))->validate($this);
        }

        return $this;
    }

    /**
     * 发送信息.
     *
     * @return void
     *
     * @throws \Throwable
     */
    protected function sendMsg()
    {
        try {
            $url = sprintf(config('wechat.wx_work.msg_host'), (new AccessTokenService($this->noticeType))->getData());
            $res = RequestTools::make()->request('post', $url, $this->data);
            Log::info('request_info', ['url' => $url, 'data' => $this->data, 'res' => $res]);
        } catch (Exception $exception) {
            throw_if_str(true, '请求发送信息异常' . $exception->getMessage());
        }
    }
}
