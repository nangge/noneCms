<?php
/**
 * Created by PhpStorm.
 * User: nango
 * Date: 2018/1/3
 * Time: 17:23
 */

namespace app\common\model;

use think\facade\Env;
use think\Model;

class Product extends Model
{
    protected $pk = 'id';

    const FLAG_DEFAULT = 0;
    const FLAG_TOP = 9;

    static $flag_desc = [
        self::FLAG_DEFAULT => '默认',
        self::FLAG_TOP => '置顶'
    ];

    /**
     * 自动完成数据
     * @var array
     */
    protected $auto = ['editor','litpic', 'pictureurls'];

    protected $update = ['updatetime'];

    public function category() {
        return $this->belongsTo('Category','cid');
    }

    public function setPublishtimeAttr($value)
    {
        return $value ? strtotime($value) : time();
    }

    public function setUpdatetimeAttr() {
        return time();
    }

    /**
     * 增加flag属性 判断是哪个编辑器添加的内容
     * @return int
     */
    public function setEditorAttr()
    {
        return get_system_value('site_editor') == 'markdown' ? 2 : 1;
    }

    /**
     * 描述处理
     * @param $value
     * @param $data
     * @return string
     */
    public function setDescriptionAttr($value, $data)
    {
        if (!$value) {
            $value = strip_tags($data['content']);
        }
        return mb_substr($value, 0, 180, 'utf-8');
    }

    /**
     * 图片处理
     * @param $value
     * @param $data
     * @return string
     */
    public function setLitpicAttr($value,$data) {

        if (isset($data['pic_url'])) {
            //获取图片缩略图宽高
            $config = System::where('name', 'in', ['display_thumbw', 'display_thumbh'])
                ->field('value')
                ->select();
            $thumb_width = $config[0]['value'];
            $thumb_height = $config[1]['value'];
            $realpath = str_replace(Env::get('root_path'), '', $data['pic_url'][0]);
            //第一张图生成缩略图
            $image = \think\Image::open('.' . $realpath);
            $type = $image->type();
            $thumb_path = './uploads/' . date('Ymd') . '/' . date('YmdHis') . '-thumb.' . $type;
            $image->thumb($thumb_width, $thumb_height)->save($thumb_path);
            $value = ltrim($thumb_path, '.');
        } else {
            $value = '';
        }
        return $value;
    }

    /**
     * 组图处理
     * @param $value
     * @param $data
     * @return string
     */
    public function setPictureurlsAttr($value,$data) {
        if (isset($data['pic_url'])) {
            return implode('|', $data['pic_url']);
        } else {
            return '';
        }
    }

    /**
     * 图片组图获取器
     * @param $value
     * @return array
     */
    public function getPicUrlAttr($value,$data) {
        return explode('|', $data['pictureurls']);
    }
}