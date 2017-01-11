<?php
namespace app\mobile\controller;

use think\Config;
use think\Db;
use think\View;

class Index extends Common
{

    public function index()
    {

        $this->assign('demo_time',$this->request->time());
        $template = 'template/mobile/'. $this->theme .'/Index_index.html';
        return $this->fetch($template);
    }

}
