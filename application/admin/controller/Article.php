<?php
/**
 * 文章
 */

namespace app\admin\controller;

use app\admin\service\grab\GrabFactory;
use app\common\model\Category;
use app\common\model\Article as articleModel;

class Article extends Common
{

    public function initialize()
    {
        parent::initialize();
        //分类
        $catgeroy = Category::all(['modelid' => 1]);
        $this->assign('category', create_tree($catgeroy->toArray()));
    }

    /**
     * 显示资源列表
     *param int $id cid
     *
     * @return \think\Response
     */
    public function index()
    {
        $id = input('param.id/d', 0);
        $where = ['status' => 0];
        $id && $where['cid'] = $id;
        $list = articleModel::where($where)
            ->order('flag DESC,publishtime DESC')
            ->paginate(20);
        foreach ($list as &$m) {
            $m['name'] = $m->cid ? $m->category->name : '';
        }

        // 获取分页显示
        $page = $list->render();
        if ($list->total() < 1) {
            $this->assign('empty', "<tr><td colspan='7'>暂无数据</td></tr>");
        }

        $this->assign([
            'page'    => $page,
            'id'      => $id,
            'data'    => $list,
            'article' => new articleModel(),
        ]);

        return $this->fetch();
    }

    /**
     * 添加文章
     */
    public function add()
    {
        //显示页面
        if (request()->isGet()) {
            return $this->fetch();
        } elseif (request()->isPost()) {
            $params = input('post.');

            $result = $this->validate($params, 'app\admin\validate\Article');

            if (true !== $result) {
                return ['status' => 0, 'msg' => $result, 'url' => ''];
            }

            $article = new articleModel;
            if ($article->data($params, true)->save()) {
                return ['status' => 1, 'msg' => '添加成功', 'url' => url('article/index', ['id' => $params['cid']])];
            } else {
                return ['status' => 0, 'msg' => '添加失败', 'url' => ''];
            }
        }
    }

    /*
     * 更新文章信息
     *
     * $id 资源id
     */
    public function edit($id = 0)
    {
        if (request()->isPost()) {
            $params = input('post.');
            $result = $this->validate($params, 'app\admin\validate\Article');

            if (true !== $result) {
                return ['status' => 0, 'msg' => $result, 'url' => ''];
            }
            $article = new articleModel();
            if (false !== $article->save($params, ['id' => $id])) {
                return ['status' => 1, 'msg' => '更新成功', 'url' => url('article/index', ['id' => $params['cid']])];
            } else {
                return ['status' => 0, 'msg' => '更新失败，请稍后重试', 'url' => ''];
            }
        } else {
            $data = articleModel::get($id);
            $this->assign('item', $data);
            return $this->fetch();
        }
    }

    public function saveToTemp()
    {
        if ($this->request->isPost()) {
            $params = input('post.');

            $result = $this->validate($params, 'app\admin\validate\Article');

            if (true !== $result) {
                return ['status' => 0, 'msg' => $result, 'url' => ''];
            }

            $article = new articleModel;
            $params['status'] = 2;
            if ($article->data($params, true)->save()) {
                return ['status' => 1, 'msg' => '添加成功', 'url' => url('article/index', ['id' => $params['cid']])];
            } else {
                return ['status' => 0, 'msg' => '添加失败', 'url' => ''];
            }
        }
    }

    /*
     * 置顶文章
     *
     * $id 资源id
     */
    public function topit()
    {
        $id = input('param.id/d');
        $flag = input('param.flag/d');

        $article = articleModel::get($id);
        $article->flag = $flag ? 0 : articleModel::FLAG_TOP;
        if ($article->save()) {
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
        if (articleModel::where('id', 'in', $ids)->update(['status' => 1])) {
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

        if (articleModel::where('id', 'in', $ids)->update(['cid' => $cid])) {
            return ['status' => 1, 'msg' => '操作成功'];
        } else {
            return ['status' => 0, 'msg' => '操作失败'];
        }
    }

    /**
     * 转载文章 暂只支持csdn
     */
    public function copy()
    {
        if (request()->isAjax()) {
            $url = input('post.url');
            $cid = input('post.cid');
            if (!$cid) {
                raise(9012, '请选择分类');
            }
            $grab = GrabFactory::get($url);
            $params = $grab->parse();
            $params['cid'] = $cid;
            $article = new articleModel();
            if ($article->data($params, true)->save()) {
                raise(1, '转载成功', ['url' => url('article/index', ['id' => $cid])], true);
            } else {
                raise(9000, '服务器繁忙，请重试');
            }
        } else {
            return $this->fetch();
        }
    }
}
