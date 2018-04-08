<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2018/3/27
 * Time: 10:59
 */

namespace app\common\lib\exception;


class EmailException extends BaseException
{
    public $code = 400;
    public $msg = '邮箱配置出错';
    public $errorCode = 20000;
}