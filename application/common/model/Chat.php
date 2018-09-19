<?php
/**
 * Created by PhpStorm.
 * User: nango
 * Date: 2018/1/8
 * Time: 15:50
 */
namespace app\common\model;

use think\Model;

class Chat extends Model {
    protected $auto = [];
    protected $insert = ['ip','send_time'];
    protected $update = [];

    protected function setIpAttr()
    {
        return request()->ip();
    }

    protected function setSendTimeAttr()
    {
        return input('server.REQUEST_TIME');
    }
}