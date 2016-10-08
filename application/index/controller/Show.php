<?php
namespace app\index\controller;

use think\Db;
use think\View;

class Show extends Common
{
    public function index()
    {
        $cid = input('param.cid');//栏目id
        $id = input('param.id');//资源id

        //根据cid来获取表模型
        $cat_info = Db::table($this->prefix . 'category cat,' . $this->prefix . 'model mo')
            ->where('cat.modelid = mo.id')
            ->where('cat.id', $cid)
            ->find();
        //获取资源内容
        $data = Db::name($cat_info['tablename'])->find($id);
        Db::name($cat_info['tablename'])->where('id',$id)->setInc('click');//点击+1

        //图片处理
        if(isset($data['pictureurls'])){
            $data['pictureurls'] = explode('|',$data['pictureurls']);
        }
        //获取模板文件
        $template_show = $cat_info['template_show'];

        if(!$template_show) {
            $model = Db::name('model')->field('template_show')->find($cat_info['modelid']);
            $template_show = $model['template_show'];
        }
        $template = 'template/'. $this->theme .'/'.$template_show;
        $this->assign('content',$data);
        $this->assign('title',$data['title']);
        $this->assign('keywords',$data['keywords']);
        $this->assign('description',$data['description']);
        $this->assign('cate',$cat_info);
        return $this->fetch($template);
    }

}
