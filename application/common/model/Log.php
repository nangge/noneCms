<?php
/**
 * Created by PhpStorm.
 * User: nango
 * Date: 2018/1/6
 * Time: 18:06
 */

namespace app\common\model;

use think\Model;

class Log extends Model {

    protected $insert = ['ip','datetime'];

    public function setIpAttr() {
        return request()->ip();
    }

    public function setDatetimeAttr() {
        return time();
    }
}