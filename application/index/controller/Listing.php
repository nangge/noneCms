<?php
namespace app\index\controller;

use think\Db;
use think\View;

class Listing extends Common
{
    public function index($cid)
    {
        $cat_info = Db::name('category')->find($cid);
        $template_list = $cat_info['template_list'];
        if(!$template_list) {
            $model = Db::name('model')->field('template_list')->find($cat_info['modelid']);
            $template_list = $model['template_list'];
        }
        $template = 'template/'. $this->theme .'/'.$template_list;
        $this->assign('cate',$cat_info);
        $this->assign('title',empty($cat_info['seotitle'])?$cat_info['name']:$cat_info['seotitle']);
        $this->assign('keywords',$cat_info['keywords']);
        $this->assign('description',$cat_info['description']);
        $this->assign('cid',$cid);
        return $this->fetch($template);
    }

}
