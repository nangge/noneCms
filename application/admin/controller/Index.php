<?php

namespace app\admin\controller;

use think\Config;
use think\Controller;
use think\Db;
use think\Exception;
use think\Request;
use think\Cache;
use think\Session;

class Index extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $userid = Session::get('userinfo.id');
        $this->assign('userid',$userid);
        return $this->fetch();
    }

    /**
     * 系统设置
     */
    function system()
    {
        if (!request()->isPost()) {
            //获取系统设置项
            $list = Db::name('system')->select();
            $slist = [];
            //获取主题
            $theme_list=scandir('template/');
            foreach($theme_list as $k => $vo){
                if($vo == '.' || $vo == '..'){
                    unset($theme_list[$k]);
                }
            }

            foreach ($list as $key => $item){
                list($pk,$ck) = explode('_',$item['name']);
                $slist[$pk][$ck] = ['name' => $item['name'],'title' => $item['title'],'tvalue' => $item['tvalue'],'value' => $item['value'],'remark' => $item['remark']];
                //如果select类型
                switch($item['name']){
                    case 'site_theme':
                        $slist[$pk][$ck]['svalue'] = $theme_list;
                        break;
                    case 'site_language':
                        $slist[$pk][$ck]['svalue'] = array('zh_cn');
                        break;
                }
            }
            $this->assign('slist',$slist);
            return $this->fetch();
        } else {
            //插入、更新操作
            try {
                $params = input('post.');
                foreach ($params as $name => $value) {
                    $flag = Db::name('system')->where('name',$name)->update(['value' => $value]);
                }
            }catch (Exception $e) {
                exception('更新操作异常');
            }
            $this->success('更新成功');
        }

    }

    /**
     * 清除缓存
     */
    function clear()
    {
        //临时文件
        $temp = RUNTIME_PATH.'/temp/';
        if(file_exists($temp)){
            if ($handle = opendir($temp)) {
                while (false !== ($file = readdir($handle))) {
                    if ($file != "." && $file != "..") {
                        $flag = unlink($temp.$file);
                    }
                }
                closedir($handle);
            }

            if($flag) {
                exit(json_encode(['status' => 1,'msg' => '清除缓存成功！']));
            } else {
                exit(json_encode(['status' => 0,'msg' => '清除缓存失败！']));
            }
        }
        exit(json_encode(['status' => 1,'msg' => '清除缓存成功！']));
    }

    /*
     * 测试
     */
    public function test(){

    }
}
