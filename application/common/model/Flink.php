<?php
/**
 * Created by PhpStorm.
 * User: nango
 * Date: 2018/1/7
 * Time: 15:07
 */

namespace app\common\model;

use think\Model;

class Flink extends Model {

    const TYPE_LINK = 1;
    const TYPE_COMMENT = 2;

    static $type_desc = [
        self::TYPE_LINK => '友情链接',
        self::TYPE_COMMENT => '公告',
    ];

    protected $auto = ['logo',];
    protected $insert = ['create_time'];

    public function setCreateTimeAttr() {
        return time();
    }

    /**
     * 图片处理
     * @param $value
     * @param $data
     * @return string
     */
    public function setLogoAttr($value,$data) {

        if (isset($data['pic_url'])) {
            $value = implode('|', $data['pic_url']);
        } else {
            $value = '';
        }
        return $value;
    }
}