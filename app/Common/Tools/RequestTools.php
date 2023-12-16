<?php

namespace App\Common\Tools;

use Yurun\Util\HttpRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Request請求工具文件.
 */
class RequestTools
{
    /**
     * @var HttpRequest
     */
    protected $http;
    protected $cookies;
    protected $timeout = 10000; // 超时时间10s
    protected $headers = [];

    //默认配置
    const DEFAULT_MAPPING = [
        'timeout'       => 10 * 1000, //超时时间10s
        'content_type'  => 'json',    //请求格式
        'headers'       => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
        'is_log_result' => true,
    ];

    /**
     * 构建单例结构体.
     *
     * @return static
     */
    public static function make($configs = [])
    {
        return tap(app(static::class), function ($that) use ($configs) {
            /* @var $that static */
            $that->http = new HttpRequest();
            //兼容直接设置
            if ($configs) {
                foreach ($configs as $name => $config) {
                    $functionName = 'set' . ucfirst($name);
                    if (function_exists($functionName)) {
                        $that->$functionName = $config;
                    }
                }
            }
        });
    }

    /**
     * 发起请求.
     *
     * @param $method
     * @param $url
     * @param array $data
     *
     * @return array|mixed|void
     */
    public function request($method, $url, array $data = [])
    {
        $this->validate([
            'method' => $method,
            'url'    => $url,
            'data'   => $data,
        ]);

        $startTime = microtime(true);

        try {
            //设置完整请求头以及超时时间、以及cookie
            $this->setHeaders(array_merge(self::DEFAULT_MAPPING['headers'], $this->headers));
            $requestHeaders = $this->headers;
            $this->http
                ->timeout($this->timeout)
                ->headers($requestHeaders);
            (!empty($this->cookies)) && $this->http->cookies($this->cookies);

            //请求流程
            if ('get' == strtolower($method)) {
                $response = $this->get($url, $data);
            } else {
                $isJson   = ('application/json' === $this->getContentType());
                $response = $this->post($url, $data, $isJson ? 'json' : '');
            }

            //请求时间
            $endTime  = microtime(true);
            $duration = $endTime - $startTime;

            // 记录请求日志
            $this->logRequest($method, $url, $data, $response, $duration);
            $responseBody = $response->body();
            return json_decode($responseBody, true) ?: [$responseBody];
        } catch (\Exception $e) {
            // 处理异常情况
            $this->handleException($e);
        }
    }

    /**
     * @param $timeout
     *
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @param $headers
     *
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param $cookies
     *
     * @return $this
     */
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;

        return $this;
    }

    /**
     * 发送GET请求.
     *
     * @return mixed|string
     */
    protected function get($url, $data = [])
    {
        return $this->http->get($url, $data);
    }

    /**
     * 发送POST请求.
     *
     * @return mixed|string
     */
    protected function post($url, $data = [], $contentType = null)
    {
        return $this->http->post($url, $data, $contentType);
    }

    /**
     * 记录日志.
     */
    protected function logRequest($method, $url, $data, $response, $duration)
    {
        Log::info('Request', [
            'method'   => $method,
            'url'      => $url,
            'data'     => $data,
            'response' => $response->body(),
            'duration' => $duration,
        ]);
    }

    /**
     * 异常抛出.
     *
     * @return mixed|string
     */
    protected function handleException($exception)
    {
        // 处理异常情况，例如记录日志、抛出自定义异常等
        Log::error('Request Error', [
            'message' => $exception->getMessage(),
            'trace'   => $exception->getTrace(),
        ]);

        throw $exception;
    }

    /**
     * 获取请求格式.
     *
     * @return mixed|string
     */
    protected function getContentType()
    {
        if (isset($this->headers['Content-Type'])) {
            return $this->headers['Content-Type'];
        }

        return 'application/json';
    }

    private function validate($valData)
    {
        //必须字段校验
        $validator = Validator::make($valData, [
            'method'  => [Rule::in(['get', 'post', 'GET', 'POST'])],
            'url'     => 'required|string|regex:/^http/',
        ]);

        //字段格式校验
        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            throw_if_str(true, '请求字段检验异常' . $errors . ':' . json_encode($valData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            throw new \Exception($errors);
        }
    }
}
