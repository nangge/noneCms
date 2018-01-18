<?php
namespace app\index\controller;

use app\common\model\Category;
use app\common\model\Modeln;
use think\Db;
use think\View;

class Listing extends Common
{
    public function index($cid)
    {
        $cat_info = Category::get($cid);

        $template_list = $cat_info['template_list'];
        if (!$template_list) {
            $template_list = Modeln::where(['id' => $cat_info['modelid']])->value('template_list');
        }
        $template = 'template/' . request()->module() . '/' . $this->theme . '/' . $template_list;
        $this->assign('cate', $cat_info);
        $this->assign('title', empty($cat_info['seotitle']) ? $cat_info['name'] : $cat_info['seotitle']);
        $this->assign('keywords', $cat_info['keywords']);
        $this->assign('description', $cat_info['description']);
        $this->assign('cid', $cid);
        return $this->fetch($template);
    }

}
