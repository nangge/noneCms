<?php

namespace app\common\model;

use think\Model;

class Category extends Model
{
    protected $pk = 'id';

    protected $auto = ['editor'];

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
        if (!$value && isset($data['content']) && !empty($data['content'])) {
            $value = strip_tags($data['content']);
        }
        return mb_substr($value, 0, 180, 'utf-8');
    }

    public function modeln() {
        return $this->belongsTo('Modeln','modelid');
    }
}
