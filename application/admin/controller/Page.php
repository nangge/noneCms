<?php
/**
 * 单页控制器
 */
namespace app\admin\controller;

use app\common\model\Category;
use think\Db;

class Page extends Common
{

    public function initialize()
    {
        parent::initialize();
        //分类
        $catgeroy = Category::where(['modelid' => 2])->field('id,pid,name,ename')->select();
        $all_cat = $catgeroy->toArray();
        //拼接导航 一级二级
//        foreach ($catgeroy as $val) {
//            if ($val['pid'] == 0) {
//                $all_cat[$val['id']] = $val;
//            } else {
//                $all_cat[$val['pid']]['children'][] = $val;
//            }
//        }

        $this->assign(['page_cat' => $all_cat,'pages' => $catgeroy]);
    }

    public function index()
    {
        return $this->fetch();
    }

    /*
     * 添加内容
     */
    public function add(){
        if (request()->isAjax()) {
            $params = input('post.');
            $result = $this->validate($params,'app\admin\validate\Page');

            if (true !== $result) {
                return ['status' => 0, 'msg' => $result, 'url' => ''];
            }
            $category = new Category();
            if ($category->save($params,['id' => $params['cid']])) {
                return ['status' => 1, 'msg' => '添加成功', 'url' => url('page/index')];
            }else{
                return ['status' => 0, 'msg' => '添加失败', 'url' => ''];
            }
        } else {
            return $this->fetch();
        }
    }

    /**
     * 修改单页面
     */
    public function edit($id){
        if (request()->isAjax()) {
            $params = input('post.');
            $result = $this->validate($params,'app\admin\validate\Page');

            if (true !== $result) {
                return ['status' => 0, 'msg' => $result, 'url' => ''];
            }
            $category = new Category();
            if (false !== $category->save($params,['id' => $params['cid']])) {
                return ['status' => 1, 'msg' => '添加成功', 'url' => url('page/index')];
            }else{
                return ['status' => 0, 'msg' => '添加失败', 'url' => ''];
            }
        } else {
            $cat_info = Category::get($id);
            $data = $cat_info->toArray();

            $this->assign('item',$data);
            return $this->fetch();
        }
        
    }

    /**
     * 删除单页面
     */
    public function dele($id){
        $flag = Category::destroy($id);
        if ($flag !== false) {
            exit(json_encode(['status' => 1, 'msg' => '删除成功']));
        }else{
            exit(json_encode(['status' => 0, 'msg' => '删除失败']));
        }
    }
}
