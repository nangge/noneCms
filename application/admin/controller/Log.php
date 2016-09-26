<?php
/**
 * 单页控制器
 */
namespace app\admin\controller;

use think\Db;

class Log extends Common
{

    public function index()
    {
        $list = Db::name('log')->paginate(20);
        $this->assign('page',$list->render());
        $this->assign('list', $list);
        return $this->fetch();
    }

}
