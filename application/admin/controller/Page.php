<?php
/**
 * 单页控制器
 */
namespace app\admin\controller;

use app\admin\model\Category;
use think\Db;

class Page extends Common
{

    public function __construct()
    {
        parent::__construct();
        //分类
        $catgeroy = Db::name('category')->field('id,pid,name')->where('modelid', 2)->select();
        $all_cat = [];
        //拼接导航 一级二级
        foreach ($catgeroy as $val) {
            if ($val['pid'] == 0) {
                $all_cat[$val['id']] = $val;
            } else {
                $all_cat[$val['pid']]['children'][] = $val;
            }
        }
        $this->assign('page_cat',$all_cat);
    }

    public function index()
    {
        $pages = Db::name('category')->field('name,ename,id')->where('modelid', 2)->select();
        $this->assign('pages', $pages);
        return $this->fetch();
    }

    /*
     * 添加单页面
     */
    public function add(){
        if (request()->isPost()) {
            //新增处理
            $params = input('post.');
            $cid = $params['cid'];
            unset($params['cid']);
            $flag = Category::where('id',$cid)->update($params);
            if ($flag) {
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            return $this->fetch();
        }
    }

    /**
     * 修改单页面
     */
    public function edit($id){
        $cat_info = Category::get($id);
       // print_r($cat_info);die;
        $data = $cat_info->toArray();
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 删除单页面
     */
    public function dele($id){
        $flag = Category::destroy($id);
        if ($flag) {
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
}
