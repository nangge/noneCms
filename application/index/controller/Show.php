<?php
namespace app\index\controller;

use app\common\model\Category;
use think\Db;
use think\View;

class Show extends Common
{
    public function index()
    {
        $cid = input('param.cid');//栏目id
        $id = input('param.id');//资源id

        //根据cid来获取表模型
        $cat_info = Category::get(['id' => $cid]);
        $modeln = $cat_info->modeln;

        //获取资源内容
        $data = Db::name($modeln['tablename'])->find($id);
        Db::name($modeln['tablename'])->where('id',$id)->setInc('click');//点击+1

        //图片处理
        if(isset($data['pictureurls'])){
            $data['pictureurls'] = explode('|',$data['pictureurls']);
        }

        //获取模板文件
        $template_show = $cat_info['template_show']?:$modeln['template_show'];

        $template = 'template/' . request()->module() . '/'. $this->theme .'/'.$template_show;
        $this->assign('content',$data);
        $this->assign('title',$data['title']);
        $this->assign('keywords',$data['keywords']);
        $this->assign('description',$data['description']);
        $this->assign('cate',$cat_info);
        $this->assign('id',$id);
        $this->assign('cid',$cid);
        return $this->fetch($template);
    }

}
