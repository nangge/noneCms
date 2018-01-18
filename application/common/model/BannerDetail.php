<?php
/**
 * Created by PhpStorm.
 * User: nango
 * Date: 2018/1/3
 * Time: 14:41
 */
namespace app\common\model;

use think\Model;

class BannerDetail extends Model
{
    protected $pk = 'id';

    protected $auto = ['img'];
    /**
     * 图片处理
     * @param $value
     * @param $data
     * @return string
     */
    public function setImgAttr($value,$data) {

        if (isset($data['pic_url'])) {
            $value = implode('|', $data['pic_url']);
        } else {
            $value = '';
        }
        return $value;
    }
}