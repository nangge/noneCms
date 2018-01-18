<?php
/**
 * Created by PhpStorm.
 * User: nango
 * Date: 2018/1/3
 * Time: 17:23
 */

namespace app\common\model;

use think\Model;

class Article extends Model
{
    protected $pk = 'id';

    const FLAG_DEFAULT = 0;
    const FLAG_TOP1 = 1;
    const FLAG_TOP = 9;

    static $flag_desc = [
        self::FLAG_DEFAULT => '默认',
        self::FLAG_TOP1 => '置顶',
        self::FLAG_TOP => '置顶'
    ];
    /**
     * 自动完成数据
     * @var array
     */
    protected $auto = ['editor','litpic'];

    public function category() {
        return $this->belongsTo('Category','cid');
    }

    public function setPublishtimeAttr($value)
    {
        return $value ? strtotime($value) : time();
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
            $value = implode('|', $data['pic_url']);
        } else {
            $value = '';
        }
        return $value;
    }
}