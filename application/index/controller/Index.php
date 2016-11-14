<?php
namespace app\index\controller;

use think\Config;
use think\Db;
use think\View;

class Index extends Common
{
    public function index()
    {

        $this->assign('demo_time',$this->request->time());
        $template = 'template/'. $this->theme .'/Index_index.html';
        return $this->fetch($template);
    }

    public function hello(){
        /*$prev_year = strtotime('-1 year');
        $pyear = date('Y',$prev_year);
        $cyear = date('Y',time());

        echo $pyear.'--'.$cyear;*/

         $login_list = Db::name('log')->whereOr('content',['like','%首页'],['like','index%'])->fetchSql(true)->select();
         print_r($login_list);
       
        //print_r(url('index/index',['id' => 2]));
    }

    public function chat(){
        return $this->fetch();
    }
}
