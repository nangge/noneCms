<?php
/**
 * Created by PhpStorm.
 * User: nango
 * Date: 2018/1/3
 * Time: 14:41
 */
namespace app\common\model;

use think\Model;

class Banner extends Model
{
    protected $pk = 'id';

    public function setStartTimeAttr($value){
        return strtotime($value);
    }

    public function setEndTimeAttr($value){
        return strtotime($value);
    }

    /**
     * 字列表
     * @return \think\model\relation\HasMany
     */
    public function lists() {
        return $this->hasMany('BannerDetail','pid');
    }
}