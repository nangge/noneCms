<?php
/**
 * Created by PhpStorm.
 * User: nango
 * Date: 2018/1/3
 * Time: 17:23
 */

namespace app\common\model;

use think\Model;

class AdminRole extends Model
{
    protected $pk = 'id';

    protected $insert = ['createtime'];

    public function setCreatetimeAttr() {
        return time();
    }


}