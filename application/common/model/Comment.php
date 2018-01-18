<?php
/**
 * Created by PhpStorm.
 * User: nango
 * Date: 2018/1/6
 * Time: 16:13
 */
namespace app\common\model;

use think\Model;

class Comment extends Model {
    protected $pk = 'id';

    protected $insert = ['create_time'];

    public function setCreatetimeAttr() {
        return time();
    }
}