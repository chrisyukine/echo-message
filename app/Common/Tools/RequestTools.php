<?php

namespace App\Common\Tools;

use Yurun\Util\HttpRequest;
use Illuminate\Support\Facades\Log;

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

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    public function setCookies($cookies)
    {
        $this->cookies = $cookies;

        return $this;
    }
    
    public function get(){
        
    }

    public function post($url, $data = [], $contentType = null)
    {
        $this->http->post($url, $data, $contentType);
    }
    
    public function request($method, $url, $data = [])
    {


        $startTime = microtime(true);

        try {
            //设置完整请求头
            $this->setHeaders(array_merge(self::DEFAULT_MAPPING['headers'], $this->headers));

            $requestHeaders = $this->headers;

            $isJson = false;
            if ('application/json' === $this->getContentType()) {
                $isJson = true;
            }

            $this->http->timeout($this->timeout)
                ->headers($requestHeaders)
                ->content($content);

            if (!empty($this->cookies)) {
                $this->http->cookies($this->cookies);
            }

            if($method == 'get') {
                $this->get();
            } else {
                $this->post($url, $data, $isJson ? 'json' : '');
            }

            $endTime  = microtime(true);
            $duration = $endTime - $startTime;

            // 记录请求日志
            $this->logRequest($method, $url, $data, $response, $duration);

            $responseBody = $response->body();

            return json_decode($responseBody) ?: [$responseBody];
        } catch (\Exception $e) {
            // 处理异常情况
            $this->handleException($e);
        }
    }

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

    protected function handleException($exception)
    {
        // 处理异常情况，例如记录日志、抛出自定义异常等
        Log::error('Request Error', [
            'message' => $exception->getMessage(),
            'trace'   => $exception->getTrace(),
        ]);

        throw $exception;
    }

    protected function getContentType()
    {
        if (isset($this->headers['Content-Type'])) {
            return $this->headers['Content-Type'];
        }

        return 'application/json';
    }
}
