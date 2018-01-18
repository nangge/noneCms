<?php

namespace app\admin\controller;

use think\Controller;
use think\facade\Session;

class Common extends Controller
{
    /*
     * 数据表前缀
     */
    protected $prefix = '';

    function __construct()
    {
        parent::__construct();
        $this->prefix = config('database.prefix');
        $this->checkLogin();
        if (!has_auth_by_route()) {
            if (request()->isAjax()) {
                exit(json_encode(['status' => 0, 'msg' => '未获取权限，请联系超级管理员开通相应权限！']));
            } else {
                echo '<div style="width:600px;margin:0 auto;margin-top:20%;font-size:26px;font-weight:bolder">未获取权限，请联系超级管理员开通相应权限！</div>';exit;
            }
        }
        $this->assign('web_site',$this->request->domain());
        $this->assign('all_nav', getAllCategory('all'));//获取所有导航
    }

    /**
     * 验证是否登录
     */
    protected function checkLogin(){

        //验证是否登录成功
        if (!Session::has('userinfo') || !$uname = Session::get('userinfo.name')) {
            $this->redirect('login/index');
        }
        //登录是否过期 无操作1h即为过期
        $login_time = Session::get('userinfo.login_time');
        if (time() - $login_time > 3600) {
            Session::clear();
            $this->redirect('login/index');
        }
        Session::set('userinfo.login_time',time());
        $this->assign('username', $uname);
    }

    /**
     * 无刷新重载栏目
     * @return json
     */
    function reloadCategory(){
        $cate = getAllCategory('all');
        exit(json_encode($cate));
    }
    /*
     * 空操作
     */
    public function _empty()
    {
        abort(404,'页面不存在啊，别乱入啊！');
    }
}
