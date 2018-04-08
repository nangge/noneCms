<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2018/3/28
 * Time: 14:44
 */

namespace app\common\lib\log;
use PHPMailer\PHPMailer\Exception;
use Raven_Client;
use Raven_ErrorHandler;

class SentryLog
{
    protected  $dsn = 'https://cd8fc57db1ef4d86b41d85070f933ffa:4836cd2f9e904acc9f3a525951bf3069@sentry.io/711251';
    protected $client;
    public function __construct($config)
    {
        if(!$config){
            $this->dsn = $config;
        }
        try{
            $sentryClient = new Raven_Client($this->dsn);
            $error_handler = new Raven_ErrorHandler($sentryClient);
            $error_handler->registerExceptionHandler();
            $error_handler->registerErrorHandler();
            $error_handler->registerShutdownFunction();
            $this->client = $sentryClient;
        }catch (Exception $e){
            throw new Exception('Client Keys 配置不正确');
        }

    }

    public function addLog($e,$data = []){
        $this->client->captureException($e, $data);
    }
}