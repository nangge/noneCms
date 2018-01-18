<?php

namespace app\admin\controller;

use app\common\model\Article;
use app\common\model\Category;
use app\common\model\Modeln;
use app\common\model\Product;
use think\Db;
use think\Exception;

class Nav extends Common
{

    public function initialize()
    {
        parent::initialize();
        //获取已定义模型
        $model = Modeln::all();

        //已添加栏目
        $category = getAllCategory('all');

        $this->assign('model', $model);
        $this->assign('category', $category);
    }

    //导航页
    function index()
    {
        return $this->fetch();
    }

    /**
     * 添加导航
     * @return array|mixed
     */
    function add()
    {
        if (request()->isGet()) {
            //获取主题下的列表和展示模板
            $theme = get_system_value('site_theme');
            $dir = 'template/index/' . $theme . '/';
            $list_dir = glob($dir . 'List_*');
            $list_dir2 = glob($dir . 'Guestbook_*');
            $list_dir = array_merge($list_dir, $list_dir2);
            $show_dir = glob($dir . 'Show_*');
            $list_template = $show_template = [];
            foreach ($list_dir as $key => $value) {
                $list_template[] = str_replace($dir, '', $value);
            }
            foreach ($show_dir as $key => $value) {
                $show_template[] = str_replace($dir, '', $value);
            }
            $this->assign([
                'list_template' => $list_template,
                'show_template' => $show_template
            ]);

            return $this->fetch();
        } elseif (request()->isPost()) {
            $data = input('post.');
            if ($data['type'] == 0 && !$data['modelid']) {
                return ['status' => 0, 'msg' => '请先选择栏目模型'];
            }
            //新增导航
            $category = new Category();
            if ($category->data($data, true)->save()) {
                return ['status' => 1, 'msg' => '栏目添加成功', 'url' => url('nav/index'), 'type' => 'nav'];
            } else {
                return ['status' => 0, 'msg' => '栏目添加失败', 'url' => url('nav/index'), 'type' => 'nav'];
            }
        }

    }

    /*
     * 编辑导航
     */
    public function edit()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $category = new Category();

            if (false !== $category->save($data, ['id' => $data['id']])) {
                return ['status' => 1, 'msg' => '栏目修改成功', 'url' => url('nav/index'), 'type' => 'nav'];
            } else {
                return ['status' => 0, 'msg' => '栏目修改失败', 'url' => url('nav/index'), 'type' => 'nav'];
            }
        } else {
            $id = input('param.id/d', 0);
            //获取主题下的列表和展示模板
            $theme = get_system_value('site_theme');

            $dir = 'template/index/' . $theme . '/';
            $list_dir = glob($dir . 'List_*');
            $show_dir = glob($dir . 'Show_*');
            foreach ($list_dir as $key => $value) {
                $list_template[] = str_replace($dir, '', $value);
            }
            foreach ($show_dir as $key => $value) {
                $show_template[] = str_replace($dir, '', $value);
            }
            $this->assign([
                'list_template' => $list_template,
                'show_template' => $show_template
            ]);

            $this->assign('data', Category::get($id));
            return $this->fetch();
        }

    }

    /**
     * 删除导航
     * @return array
     */
    public function dele()
    {
        $id = input('param.id/d', 0);

        if (empty($id)) {
            return ['status' => 0, 'msg' => '参数缺失'];
        }

        try {
            Db::startTrans();
            $category = Category::get($id);
            $relationModel = '';
            switch ($category->modelid) {
                case 1:
                    $relationModel = new Article();
                    break;
                case 3:
                    $relationModel = new Product();
                    break;
            }
            if ($category->delete()) {
                $relationModel && $relationModel->save(['status' => 1],['cid' => $id]);
            } else {
                throw new Exception('删除失败');
            }

            Db::commit();
            return ['status' => 1, 'msg' => '删除成功'];
        } catch (Exception $e) {
            Db::rollback();
            return ['status' => 0, 'msg' => $e->getMessage()];
        }

    }
}
