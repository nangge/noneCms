<?php
/**
 * 单页控制器
 */
namespace app\admin\controller;

use app\admin\model\Category;
use think\Db;

class Banner extends Common
{

    public function index()
    {
        $banner = Db::name('banner')->where(['status' => 0])->select();
        $this->assign('banner', $banner);
        return $this->fetch();
    }

    /*
     * 添加内容
     */
    public function add(){
        if (request()->isPost()) {
            //新增处理
            $params = input('post.');
            
            $flag = Db::name('banner')->insert($params);
            if ($flag !== false) {
                exit(json_encode(['status' => 1, 'msg' => '添加成功', 'url' => url('banner/index')]));
            }else{
                exit(json_encode(['status' => 0, 'msg' => '添加失败', 'url' => '']));
            }
        }else{
            return $this->fetch();
        }
    }

    /**
     * 修改
     */
    public function edit(){
        $id = input('param.id');
        if (request()->isPost()) {
            $params = input('post.');
            unset($params['id']);
            $flag = Db::name('banner')->where('id', $id)->update($params);
            if ($flag !== false) {
                exit(json_encode(['status' => 1, 'msg' => '修改成功', 'url' => url('banner/index')]));
            }else{
                exit(json_encode(['status' => 0, 'msg' => '修改失败', 'url' => '']));
            }
        } else {
            $data = Db::name('banner')->find($id);
            $this->assign('item',$data);
            return $this->fetch();
        }
    }

    /**
     * 删除
     */
    public function dele($id){
        $flag = Db::name('banner')->where(['id' => $id])->update(['status' => 1]);
        if ($flag !== false) {
            exit(json_encode(['status' => 1, 'msg' => '删除成功']));
        }else{
            exit(json_encode(['status' => 0, 'msg' => '删除失败']));
        }
    }

    /**
     * Banner 已添加图片列表
     * @return 
     */
    public function banlist($id)
    {
        $cate = Db::name('banner')->field('title,type,id')->find($id);
        $list = Db::name('banner_detail')->where(['pid' => $id])->select();
        
        $this->assign([
            'list' => $list,
            'cate' => $cate
            ]);
        return $this->fetch();
    }

    /**
     * 添加banner内容
     */
    public function addDetail($id = 0){
        if (request()->isAjax()) {
            //新增处理
            $params = input('post.');
            if (isset($params['pic_url'])) {
                $params['img'] = implode('|',$params['pic_url']);
                unset($params['pic_url']);
            }else{
                $params['img'] = '';
            }
            $flag = Db::name('banner_detail')->insert($params);
            if ($flag) {
                exit(json_encode(['status' => 1, 'msg' => '添加成功', 'url' => url('banner/banlist')]));
            }else{
                exit(json_encode(['status' => 0, 'msg' => '添加失败', 'url' => '']));
            } 
            
        }else{
            $this->assign('pid',$id);
            return $this->fetch();
        }
    }

    /**
     * 编辑大图
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function editDetail(){
        if (request()->isPost()) {
            $params = input('post.');
            if (isset($params['pic_url'])) {
                $params['img'] = implode('|',$params['pic_url']);
                unset($params['pic_url']);
            }else{
                $params['img'] = '';
            }
            $flag = Db::name('banner_detail')->where(['id' => $params['id']])->update($params);
            if ($flag) {
                exit(json_encode(['status' => 1, 'msg' => '修改成功', 'url' => url('banner/banlist')]));
            }else{
                exit(json_encode(['status' => 0, 'msg' => '修改失败', 'url' => '']));
            }
        } else {
            $id = input('param.id/d',0);
            $item = Db::name('banner_detail')->find($id);
            $this->assign('item',$item);
            return $this->fetch();
        }
    }

    public function deleDetail($id){
        $flag = Db::name('banner_detail')->delete($id);
        if ($flag) {
            echo '删除成功！';
        }else{
            echo '删除失败！';
        }
    }
}
