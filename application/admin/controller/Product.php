<?php
/**
 *产品模型
 */

namespace app\admin\controller;

use app\common\model\Category;
use app\common\model\Product as productModel;
use app\common\model\System;
use think\Db;
use think\facade\Env;

class Product extends Common
{
    /*
     * 产品表
     */
    private static $_table = 'product';

    public function initialize()
    {
        parent::initialize();
        $catgeroy = Category::where('modelid', 3)->order('id ASC')->select();
        $this->assign('category', create_tree($catgeroy->toArray()));
    }

    /**
     * 显示资源列表
     *param int $id cid
     * @return \think\Response
     */
    public function index()
    {
        $id = input('param.id/d', 0);
        $where = ['status' => 0];
        $id && $where['cid'] = $id;
        $list = productModel::where($where)
            ->order('flag DESC,publishtime DESC')
            ->paginate(10);
        foreach ($list as &$m) {
            $m['name'] = $m->cid ? $m->category->name : '';
        }
        // 获取分页显示
        $page = $list->render();

        if ($list->total() < 1) {
            $this->assign('empty', "<tr><td colspan='7'>暂无数据</td></tr>");
        }
        $this->assign('page', $page);
        $this->assign("id", $id);
        $this->assign('data', $list);
        return $this->fetch();
    }

    /**
     * 添加产品
     *
     */
    public function add()
    {
        //显示页面
        if (request()->isGet()) {
            return $this->fetch();
        } elseif (request()->isPost()) {
            $params = input('post.');
            $result = $this->validate($params, 'app\admin\validate\Product');
            if (true !== $result) {
                return ['status' => 0, 'msg' => $result, 'url' => ''];
            }

            $product = new productModel();
            if ($product->data($params, true)->save()) {
                return ['status' => 1, 'msg' => '添加成功', 'url' => url('product/index', ['id' => $params['cid']])];
            } else {
                return ['status' => 0, 'msg' => '添加失败', 'url' => ''];
            }

        }
    }

    /*
     * 更新产品信息
     *
     * $id 资源id
     */
    public function edit($id = 0)
    {
        //显示页面
        if (request()->isGet()) {
            $this->assign('item', productModel::get($id));
            return $this->fetch();
        } elseif (request()->isPost()) {
            $params = input('post.');
            $product = new productModel();
            if (false !== $product->save($params,['id' => $id])) {
                return ['status' => 1, 'msg' => '更新成功', 'url' => url('product/index', ['id' => $params['cid']])];
            } else {
                return ['status' => 0, 'msg' => '更新失败，请稍后重试', 'url' => ''];
            }
        }

    }

    /*
     * 置顶
     *
     * $id 资源id
     */
    public function topit()
    {
        $id = input('param.id/d');
        $flag = input('param.flag');
        $product = productModel::get($id);
        $product->flag = $flag ? 0 : productModel::FLAG_TOP;
        if ($product->save()) {
            return ['status' => 1, 'msg' => '操作成功'];
        } else {
            return ['status' => 0, 'msg' => '操作失败'];
        }
    }

    /*
     * 删除资源
     * @param id int 资源id
     */
    public function dele()
    {
        if (input('?param.checkbox')) {
            $ids = input('param.checkbox/a');
        } else {
            $ids = input('param.id/d', 0);
        }
        //逻辑删除
        if (productModel::where('id', 'in', $ids)->update(['status' => 1])) {
            return ['status' => 1, 'msg' => '删除成功'];
        } else {
            return ['status' => 0, 'msg' => '删除失败'];
        }
    }

    /*
     * 移动分类
     */
    public function move()
    {
        $params = input('param.');
        $cid = $params['new_cat_id'];
        $ids = $params['checkbox'];

        if (productModel::where('id', 'in', $ids)->update(['cid' => $cid])) {
            return ['status' => 1, 'msg' => '操作成功'];
        } else {
            return ['status' => 0, 'msg' => '操作失败'];
        }
    }

}
