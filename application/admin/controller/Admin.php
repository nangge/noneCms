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
        $list = Db::name('admin')
            ->alias('adm')
            ->join($this->prefix.'admin_role role', 'adm.role_id=role.id', 'LEFT')
            ->field('adm.username,adm.logintime,adm.id,adm.loginip,adm.email,adm.islock,adm.usertype,role.name')
            ->where('adm.islock','neq',3) //非删除
            ->select();
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
                'repassword' => $params['repassword'],
                'role_id' => $params['role_id'],
            ];
            //验证规则
            $validate = Loader::validate('Admin');

            
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

            
        } else {
            $role = Db::name('admin_role')->field('id,name')->select();
            $this->assign('role',$role);
            return $this->fetch();
        }
    }

    /**
     * 修改用户信息
     */
    public function edit($id)
    {
        if (request()->isPost()) {
            //修改处理
            $params = input('post.');
            $data = [
                'username' => $params['user_name'],
                'password' =>  $params['password'],
                'email' => $params['email'],
                'islock' => $params['islock'],
                'repassword' => $params['repassword'],
                'role_id' => $params['role_id'],
            ];
            //验证规则
            $validate = Loader::validate('Admin');

            
            //更新操作
            // if($params['old_password']){
            //     $info = Db::name('admin')->field('password,encrypt')->find($params['id']);
            //     $password = get_password($params['old_password'],$info['encrypt']);
            //     if($info['password'] != $password){
            //         exit(json_encode(['status' => 0, 'msg' => '原密码不正确', 'url' => '']));
            //     }
            // }
            if(!$validate->scene('edit')->check($data)){
                $error = $validate->getError();
                exit(json_encode(['status' => 0, 'msg' => $error, 'url' => '']));
            }
            if ($data['password']) {
              $data['encrypt'] = get_randomstr();//6位hash值
              $data['password'] = get_password($data['password'],$data['encrypt']);
            }
             
            unset($data['repassword']);
            $flag = Db::name('admin')->where('id',$params['id'])->update($data);
            if ($flag) {
                exit(json_encode(['status' => 1, 'msg' => '修改成功', 'url' => url('admin/index')]));
            } else {
                exit(json_encode(['status' => 0, 'msg' => '修改失败,请稍后重试', 'url' => '']));
            }
            
        } else {
            $data = Db::name('admin')->find($id);
            $role = Db::name('admin_role')->field('id,name')->select();
            $this->assign('role',$role);
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    /**
     * 删除用户信息
     */
    public function dele()
    {
        $id = input('param.id/d',0);
        $flag = Db::name('admin')->where(['id' => $id])->update(['islock' => 3]);
        if ($flag !== false) {
            exit(json_encode(['status' => 1, 'msg' => '删除成功']));
        }else{
            exit(json_encode(['status' => 0, 'msg' => '删除失败']));
        }
    }
}
