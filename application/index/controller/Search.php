<?php
namespace app\index\controller;

use think\Db;
use think\View;

class Search extends Common
{
    /**
     * 搜索
     * *
    **/
    public function index(){
        $keywords = input('param.keywords');
        $list = Db::name('article')->where('status',0)->where('title','like','%'.$keywords.'%')->paginate(15);
        $this->assign('page',$list->render());
        $this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * 根据时间获取相关文章
     * @return mixed
     */
    public function search4Date(){
        $stime = strtotime(input('param.date'));
        $etime = strtotime('+1 month',$stime);
        $list = Db::name('article')->where('status',0)->whereTime('publishtime','between',[$stime,$etime])->paginate(15);
        $this->assign('page',$list->render());
        $this->assign('list',$list);
        return $this->fetch('index');
    }

}
