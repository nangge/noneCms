<?php
/**
 *产品模型
 */

namespace app\admin\controller;

use think\Config;
use think\Controller;
use think\Db;
use think\Request;

class Product extends Common
{
    /*
     * 产品表
     */
    private static $_table = 'product';


    /*
     * 存储表对象
     */
    private static $db = '';


    public function __construct()
    {
        parent::__construct();

        //分类
        $catgeroy = Db::name('category')->field('id,pid,name')->where('modelid', 3)->select();
        $all_cat = [];
        //拼接导航 一级二级
        foreach ($catgeroy as $val) {
            if ($val['pid'] == 0) {
                $all_cat[$val['id']] = $val;
            } else {
                $all_cat[$val['pid']]['children'][] = $val;
            }
        }

        $this->assign('category', $all_cat);
    }

    /**
     * 显示资源列表
     *param int $id cid
     * @return \think\Response
     */
    public function index($id = 0)
    {
        //$list = Db::name(self::$_table)->field('id,title,publishtime,cid')->order('id DESC');
        $list = Db::field('p.id,p.title,p.publishtime,p.cid,c.name')
            ->table($this->prefix.'product p,'.$this->prefix.'category c')
            ->where('p.cid = c.id')
            ->where('p.status',0);
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
     * 添加产品
     *
     */
    public function add()
    {
        //获取图片缩略图宽高
        $config = Db::name('system')->field('value')->where('name','in',['display_thumbw','display_thumbh'])->select();
        $thumb_width = $config[0]['value'];
        $thumb_height = $config[1]['value'];
        //显示页面
        if (request()->isGet()) {
            return $this->fetch();
        } elseif (request()->isPost()) {
            $params = input('post.');
            if (isset($params['pic_url'])) {

                $realpath = str_replace('/..\/','/',ROOT_PATH.$params['pic_url'][0]);
                //第一张图生成缩略图
                $image = \think\Image::open($realpath);
                $type = $image->type();
                $thumb_path = './uploads/'.date('Ymd').'/'.date('YmdHis').'-thumb.'.$type;
                $image->thumb($thumb_width,$thumb_height)->save($thumb_path);
                if(__ROOT__){
                    $params['litpic'] = __ROOT__.ltrim($thumb_path,'.');
                }else{
                    $params['litpic'] = ltrim($thumb_path,'.');
                }

                $params['pictureurls'] = implode('|',$params['pic_url']);
                unset($params['pic_url']);
            }

            if (!$params['id']) {
                //新增
                unset($params['id']);
                $params['publishtime'] = strtotime("now");
                $flag = Db::name(self::$_table)->insert($params);
                if ($flag) {
                    $this->success('添加成功', 'product/index?id='.$params['cid']);
                } else {
                    $this->error('添加失败', 'product/error?id='.$params['cid']);
                }
            } else {
                //更新
                $id = $params['id'];
                unset($params['id']);
                $params['updatetime'] = strtotime("now");
                $flag = Db::name(self::$_table)->where('id', $id)->update($params);
                if ($flag) {
                    $this->success('更新成功', 'product/index?id='.$params['cid']);
                } else {
                    $this->error('更新失败', 'product/error?id='.$params['cid']);
                }
            }
        }
    }

    /*
     * 更新产品信息
     *
     * $id 资源id
     */
    public function edit($id = 0) {
        $data = Db::name(self::$_table)->where('id',$id)->find();
        $data['pic_url'] = explode('|',$data['pictureurls']);
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
        $flag = self::$db->where('id','in',$ids)->update(['status' => 1]);
        if ($flag) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    /*
     * 移动分类
     */
   public function move(){
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
     * 图片上传
     */
    public function upload()
    {
        if (request()->isPost()) {
            $file = request()->file('pic_url');
            $info = $file->move(ROOT_PATH . 'public/uploads');
            if ($info) {
                // 成功上传后 获取上传信息
                $path = $info->getPath();
                $filename = $info->getFilename();
                //$root = request()->domain();
                $save_name = $info->getSaveName();
                if(__ROOT__){
                    $realpath =  __ROOT__.'/uploads/' . $save_name;
                }else{
                    $realpath =  '/uploads/' . $save_name;
                }
                exit(json_encode(['status' => 1, 'path' => $realpath, 'save_name' => $save_name]));
            } else {
                // 上传失败获取错误信息
                exit(json_encode(['status' => 1, 'error' => $file->getError()]));
            }
        } elseif (request()->isGet()) {
            //删除图片
            $real_path = request()->get('path');
            $path = ROOT_PATH . 'public/uploads/' . $real_path;
            if (unlink($path)) {
                exit(json_encode(['status' => 1, 'msg' => '删除成功']));
            } else {
                exit(json_encode(['status' => 0, 'msg' => '删除成功']));
            }
        }
    }
}
