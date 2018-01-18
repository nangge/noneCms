<?php
/**
 * 操作日志
 */
namespace app\admin\controller;


class Log extends Common
{

    public function index()
    {
        $list = \app\common\model\Log::where('1=1')->order('id DESC')->paginate(50);
        $this->assign('page',$list->render());
        $this->assign('list', $list);
        return $this->fetch();
    }

}
