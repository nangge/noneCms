<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Login extends Controller
{
    //登录界面
    function index(){
        //验证是否登录成功
        if (Session::has('userinfo')) {
            $this->redirect('index/index');
        }
        return $this->fetch();
    }

    //登录操作
    function login(){
        $name = input('post.username');
        $passwd = input('post.password');
        $captcha = input('post.captcha');

        if (!$name || !$passwd) {
            $this->error('用户名和密码不能为空！','login/index');
        }

        if(!captcha_check($captcha)){
            $this->error('请输入正确的验证码！','login/index');
        }

        $info = Db::name('admin')->where('username',$name)->find();
        $md5_passwd = md5(md5(trim($passwd)).$info['encrypt']);

        if (!$info || $md5_passwd != $info['password']) {
            $this->error( '用户名或密码错误，请重新输入！','login/index');
        }

        if ($info['islock'] != 0) {
            $this->error( '您的账户暂时已锁定，请联系管理员！','login/index');
        }

        //写入日志
        $data['ip'] = $login['loginip'] = request()->ip();
        $data['userid'] = $info['id'];
        $data['datetime'] = $login['logintime'] = time();
        Db::name('log')->insert($data);
        Db::name('admin')->where('id',$info['id'])->update($login);

        //登入成功，存入session
        Session::set('userinfo',['name' => $name,'id' => $info['id'],'login_time' => time()]);
        $this->success('登录成功','Index/index');

    }

    //退出
    function logout(){
        Session::clear();
        $this->success('退出成功','login/index');
    }

    /*
     * 空操作
     */
    public function _empty()
    {
        $this->redirect('login/index');
    }
}
