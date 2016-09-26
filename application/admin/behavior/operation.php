<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-08-22
 * Time: 17:32
 */
namespace app\admin\behavior;
use think\Db;
use think\Session;

class Operation
{
    public function action_begin(){
        //获取可操作栏目
        $rabc = include APP_PATH.'admin/rabc.php';
        //记录操作
        $module = request()->module();
        $controller = request()->controller();
        $action = request()->action();

        if($controller !== 'login' && isset($rabc[$controller][$action])){
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