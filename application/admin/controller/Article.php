<?php
/**
 * 文章
 */

namespace app\admin\controller;

use app\common\model\Category;
use app\common\model\Article as articleModel;
use think\Exception;

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
            $m['name'] = $m->cid?$m->category->name:'';
        }

        // 获取分页显示
        $page = $list->render();
        if ($list->total() < 1) {
            $this->assign('empty', "<tr><td colspan='7'>暂无数据</td></tr>");
        }

        $this->assign([
            'page' => $page,
            'id' => $id,
            'data' =>  $list,
            'article' => new articleModel()
        ]);

        return $this->fetch();
    }

    /**
     * 添加文章
     *
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

            if (!$url || !substr_count($url, 'csdn')) {
                exit(json_encode(['status' => 0, 'msg' => '请输入csdn博客文章地址', 'url' => '']));
            }

            if (!$cid) {
                exit(json_encode(['status' => 0, 'msg' => '请先选择分类', 'url' => '']));
            }


            try {
                \phpQuery::newDocumentFile($url);
                $title = pq('.link_title')->text();
                if (!$title) {
                    $title = pq('.list_c_t a')->text();
                }
                if (!$title) {
                    $title = pq('h1.csdn_top')->text();
                }
                $title = trim($title);

                if(mb_strlen($title,'utf-8')>60){
                    return ['status' => 0, 'msg' => '转载失败,文章标题超过60字', 'url' => ''];
                }

                $content = pq('#article_content')->text();

//                //如果抓取不到主内容
                if (!$content) {
                    throw new Exception("文章不存在或禁止爬虫");
                }
                $params['cid'] = $cid;
                $params['content'] = $content;
                $params['title'] = $title;
                $params['publishtime'] = '';
                $params['description'] = trim(strip_tags($content));
                $params['copyfrom'] = $url;
                $article = new articleModel();
                if ($article->data($params,true)->save()) {
                    return ['status' => 1, 'msg' => '转载成功', 'url' => url('article/index', ['id' => $cid])];
                } else {
                    return ['status' => 0, 'msg' => '转载失败', 'url' => ''];
                }
            } catch (Exception $e) {
                return ['status' => 0, 'msg' => '添加失败：' . $e->getMessage(), 'url' => ''];
            }
        } else {
            return $this->fetch();
        }

    }


}
