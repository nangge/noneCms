<?php
/**
 *产品模型
 */

namespace app\admin\controller;

use think\Config;
use think\Controller;
use think\Db;
use think\Request;

class Article extends Common
{
    /*
     * 产品表
     */
    private static $_table = 'article';

    /*
     * 数据库配置参数
     */
    protected $db_config = [];

    /*
     * 存储表对象
     */
    private static $db = '';


    public function __construct()
    {
        parent::__construct();
        //加载数据库配置
        $this->db_config =  Config::load(APP_PATH.'/database.php');
        //分类
        $catgeroy = Db::name('category')->field('id,pid,name')->where('modelid', 1)->select();
        $all_cat = [];
        //拼接导航 一级二级
        foreach ($catgeroy as $val) {
            if ($val['pid'] == 0) {
                $all_cat[$val['id']] = $val;
            } else {
                $all_cat[$val['pid']]['children'][] = $val;
            }
        }
        //实例化表对象
        self::$db = Db::name(self::$_table);

        $this->assign('category', $all_cat);
    }

    /**
     * 显示资源列表
     *param int $id cid
     * @return \think\Response
     */
    public function index($id = 0)
    {
        $list = Db::field('p.id,p.title,p.publishtime,p.cid,c.name')
            ->table($this->db_config['prefix'].'article p,'.$this->db_config['prefix'].'category c')
            ->where('p.cid = c.id')
            ->where('p.status',0)
            ->order('publishtime DESC');
        if($id == 0){
            $list = $list->paginate(10);
        }else{
            $list = $list->where('cid', $id)->paginate(10);
        }

        // 获取分页显示
        $page = $list->render();
        if ($list->total() < 1) {
            $this->assign('empty', "<tr><td colspan='6'>暂无数据</td></tr>");
        }
        $this->assign('page',$page);
        $this->assign("id", $id);
        $this->assign('data', $list);
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
            if (isset($params['pic_url'])) {
                $params['litpic'] = implode('|',$params['pic_url']);
                unset($params['pic_url']);
            }

            if (!$params['id']) {
                //新增
                unset($params['id']);
                $params['publishtime'] = strtotime("now");
                //描述为空 则截取内容填补
                if(!$params['description']){
                    $content = strip_tags($params['content']);
                    $params['description'] = mb_substr($content,0,180,'utf-8');
                }
                $flag = Db::name(self::$_table)->insert($params);
                if ($flag) {
                    $this->success('添加成功');
                } else {
                    $this->error('添加失败');
                }
            } else {
                //更新
                $id = $params['id'];
                unset($params['id']);
                $params['updatetime'] = strtotime("now");
                $flag = Db::name(self::$_table)->where('id', $id)->update($params);
                if ($flag) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }

    /*
     * 更新文章信息
     *
     * $id 资源id
     */
    public function edit($id = 0) {
        $data = Db::name(self::$_table)->where('id',$id)->find();
        $this->assign('item',$data);
        return $this->fetch();
    }

    /*
     * 删除资源
     * @param id int 资源id
     */
    public function dele($id = 0) {
        if(request()->isPost()){
            $params = input('post.');
            $ids = $params['checkbox'];
        }else{
            $ids = $id;
        }
        //逻辑删除
        $flag = Db::name(self::$_table)->where('id','in',$ids)->update(['status' => 1]);
        if ($flag) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    /*
     * 移动分类
     */
   public function moveCategory(){
       $params = input('post.');
       $cid = $params['new_cat_id'];
       $ids = $params['checkbox'];

       $flag = self::$db->where('id','in',$ids)->update(['cid' => $cid]);
       if ($flag) {
           $this->success('操作成功');
       } else {
           $this->error('操作失败');
       }
   }

    /**
     * 转载文章 暂只支持csdn
     */
    public function copy(){
        if(request()->isPost()){
            $url = input('post.url');
            $cid = input('post.cid');

            if(!$cid){
                $this->error('请选择分类！');
            }
            if(!$url){
                $this->error('输入文章地址！');
            }

            try {
                \phpQuery::newDocumentFile($url);
                $title = pq('.link_title a')->text();
                if (!$title) {
                    $title = pq('.list_c_t a')->text();
                }
                $content = pq('#article_content')->html();
                //如果抓取不到主内容
                if(!$content){
                    throw new DException('文章不存在！');
                }
                $params['cid'] = $cid;
                $params['content'] = $content;
                $params['title'] = $title;
                $params['publishtime'] = time();
                $params['description'] = mb_substr(trim(strip_tags($content)), 0, 180, 'utf-8');
                $params['copyfrom'] = $url;
                $flag = Db::name(self::$_table)->insert($params);
                if ($flag) {
                    $this->success('添加成功');
                } else {
                    $this->error('添加失败');
                }
            }
            catch (Exception $e){
                $this->error('添加失败：'.$e->getMessage());
            }
        }else{
            return $this->fetch();
        }

    }


}
