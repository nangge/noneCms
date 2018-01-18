<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-08-22
 * Time: 17:32
 */
namespace app\admin\behavior;
use think\Db;
use think\facade\Env;
use think\facade\Session;

class Operation
{
    public function run(){
        $this->action_begin();
    }
    
    public function action_begin(){
        //获取可操作栏目
        $rabc = include Env::get('app_path').'admin/rbac.php';
        //记录操作
        $controller = strtolower(request()->controller());
        $action = strtolower(request()->action());
        if($controller != 'login' && isset($rabc[$controller][$action])){
            $uname = Session::get('userinfo.name');
            $data['content'] = $uname.$rabc[$controller][$action];
            $data['datetime'] = time();
            $data['username'] = $uname;
            $data['ip'] = request()->ip();
            $data['type'] = 2;
            $data['userid'] = Session::get('userinfo.id');
            Db::name('log')->insert($data);
        }
    }
}