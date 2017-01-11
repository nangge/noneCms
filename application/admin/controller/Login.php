<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

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
            exit(json_encode(array('status' => 0, 'msg' => '用户名和密码不能为空')));
        }

        if(!captcha_check($captcha)){
            exit(json_encode(array('status' => 0, 'msg' => '请输入正确的验证码')));
        }

        $info = Db::name('admin')->where('username',$name)->find();
        $md5_passwd = md5(md5(trim($passwd)).$info['encrypt']);

        if (!$info || $md5_passwd != $info['password']) {
            exit(json_encode(array('status' => 0, 'msg' => '用户名或密码错误，请重新输入')));
        }

        if ($info['islock'] == 1) {
            exit(json_encode(array('status' => 0, 'msg' => '您的账户已被锁定，请联系超级管理员')));
        }

        //写入日志
        $data['ip'] = $login['loginip'] = request()->ip();
        $data['userid'] = $info['id'];
        $data['datetime'] = $login['logintime'] = time();
        Db::name('log')->insert($data);
        Db::name('admin')->where('id',$info['id'])->update($login);

        //登入成功，存入session
        Session::set('userinfo',['name' => $name,'id' => $info['id'],'login_time' => time()]);
        exit(json_encode(array('status' => 1, 'msg' => '登录成功', 'url' => url('index/index'))));

    }

    //退出
    public function logout(){
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
