<?php

namespace app\admin\controller;

use app\common\model\Admin;
use app\common\model\Log;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Cache;

class Login extends Controller
{
    //登录界面
    public function index(){
        //验证是否登录成功
        if (Session::has('userinfo')) {
            $this->redirect('index/index');
        }
        return $this->fetch();
    }

    //登录操作
    public function login(){
        if(!request()->isPost()){
            $this->redirect('index/index');
        }
        $name = input('post.username');
        $passwd = input('post.password');
        $captcha = input('post.captcha');

        if (!$name || !$passwd) {
            return array('status' => 0, 'msg' => '用户名和密码不能为空');
        }

        if(!captcha_check($captcha)){
            return array('status' => 0, 'msg' => '请输入正确的验证码');
        }

        $info = Admin::where(['username' => $name])->find();
        $md5_passwd = get_password($passwd,$info['encrypt']);

        if (!$info || $md5_passwd != $info['password']) {
            exit(json_encode(array('status' => 0, 'msg' => '用户名或密码错误，请重新输入')));
        }

        if ($info['islock'] == 1) {
            exit(json_encode(array('status' => 0, 'msg' => '您的账户已被锁定，请联系超级管理员')));
        }

        //写入日志
        $data['userid'] = $info['id'];
        $log = new Log();
        $log->data($data,true)->save();
        $admin = new Admin();
        $admin->save(['logintime' => time()],['id' => $info['id']]);//数据通过模型自动完成更新

        //登入成功，存入session
        Session::set('userinfo',['name' => $name,'role_id' => $info['role_id'],'id' => $info['id'],'usertype' => $info['usertype'],'login_time' => time()]);
        //权限存入缓存并设置auth标签
        Cache::tag('auth')->set('auth_'.$info['id'], get_power_by_uid($info['role_id']));

        return ['status' => 1, 'msg' => '登录成功', 'url' => url('index/index')];

    }

    //退出
    public function logout(){
        Cache::rm('auth_'.Session::get('userinfo.id'));
        Session::clear();
        exit(json_encode(array('status' => 1, 'msg' => '退出成功')));
    }

    /*
     * 空操作
     */
    public function _empty()
    {
        $this->redirect('login/index');
    }
}
