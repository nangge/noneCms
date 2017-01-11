<?php
/**
 * 单页控制器
 */
namespace app\admin\controller;

use app\admin\model\Category;
use think\Config;
use think\Db;
use think\Loader;

class Admin extends Common
{

    public function index()
    {
        $list = Db::name('admin')->field('username,logintime,id,loginip,email,islock')->where('islock','neq',3)->select();
        $this->assign('list', $list);
        return $this->fetch();
    }

    /*
     * 添加用户
     */
    public function add()
    {
        if (request()->isPost()) {
            //修改处理
            $params = input('post.');
            $data = [
                'username' => $params['user_name'],
                'password' =>  $params['password'],
                'email' => $params['email'],
                'islock' => $params['islock'],
                'repassword' => $params['repassword']
            ];
            //验证规则
            $validate = Loader::validate('Admin');

            if (isset($params['id'])) {
                //更新操作
                if($params['old_password']){
                    $info = Db::name('admin')->field('password,encrypt')->find($params['id']);
                    $password = get_password($params['old_password'],$info['encrypt']);
                    if($info['password'] != $password){
                        exit(json_encode(['status' => 0, 'msg' => '原密码不正确', 'url' => '']));
                    }
                }
                if(!$validate->scene('edit')->check($data)){
                    $error = $validate->getError();
                    exit(json_encode(['status' => 0, 'msg' => $error, 'url' => '']));
                }
                 $data['encrypt'] = get_randomstr();//6位hash值
                 $data['password'] = get_password($data['password'],$data['encrypt']);

                unset($data['repassword']);
                $flag = Db::name('admin')->where('id',$params['id'])->update($data);
                if ($flag) {
                    exit(json_encode(['status' => 1, 'msg' => '修改成功', 'url' => url('admin/index')]));
                } else {
                    exit(json_encode(['status' => 0, 'msg' => '修改失败,请稍后重试', 'url' => '']));
                }
            }else{
                //新增
                if(!$validate->check($data)){
                    $error = $validate->getError();
                    exit(json_encode(['status' => 0, 'msg' => $error, 'url' => '']));
                }
                unset($data['repassword']);
                $data['encrypt'] = get_randomstr();//6位hash值
                $data['password'] = get_password($data['password'],$data['encrypt']);
                $data['logintime'] = time();
                $data['createtime'] = time();
                $data['loginip'] = request()->ip();
                $data['username'] = $params['user_name'];
                $flag=Db::name('admin')->insert($data);
                if ($flag) {
                    exit(json_encode(['status' => 1, 'msg' => '添加成功', 'url' => url('admin/index')]));
                } else {
                    exit(json_encode(['status' => 0, 'msg' => '添加失败,请稍后重试', 'url' => '']));
                }
            }

            
        } else {
            return $this->fetch();
        }
    }

    /**
     * 修改用户信息
     */
    public function edit($id)
    {
        $data = Db::name('admin')->find($id);
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     * 删除用户信息
     */
    public function dele()
    {
        $id = input('param.id/d',0);
        $flag = Db::name('admin')->where(['id' => $id])->update(['islock' => 3]);
        if ($flag) {
            echo '删除成功';
        } else {
            echo '删除失败';
        }
    }
}
