<?php
/**
 *产品模型
 */

namespace app\admin\controller;

use think\Config;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Main extends Common
{


    /**
     * 显示资源列表
     *param int $id cid
     * @return \think\Response
     */
    public function index()
    {
        //环境
        $mysql_version = Db::query('SELECT VERSION() as version');
        $soft_env = input('server.SERVER_SOFTWARE');
        $php = phpversion();
        $software['php'] = $php;
        $software['os'] = PHP_OS;
        $software['env'] = $soft_env;
        $software['mysql'] = $mysql_version[0]['version'];
        $software['gd'] = extension_loaded('gd')?'是':'否';
        $this->assign('software',$software);
        //是否删除install
        $flag = file_exists('install');
        //获取登录记录
        $uid = Session::get('userinfo.id');
        $login_list = Db::name('log')->where(['userid' => $uid,'type' => 1])->order('datetime DESC')->limit(5)->select();
        $this->assign('login_list',$login_list);
        //统计产品、文章总数量
        $product_count = Db::name('product')->where('status',0)->count();
        $article_count = Db::name('article')->where('status',0)->count();
        //网站主题
        $theme = get_system_value('site_theme');
        $this->assign('theme',$theme);
        $this->assign('product_count',$product_count);
        $this->assign('article_count',$article_count);
        //获取单页栏目
        $single_page = Db::name('category')->field('id,name,ename')->where('modelid', 2)->select();
        $this->assign('single_page', $single_page);
        $this->assign('page_count',count($single_page));//单页数量
        $this->assign('flag', $flag);
        return $this->fetch();
    }


    /**
     * 图片上传
     */
    public function upload()
    {
        if (request()->isPost()) {
            $file = request()->file('pic_url');
            $info = $file->move(ROOT_PATH . 'public/uploads');
            if ($info) {
                // 成功上传后 获取上传信息
                $path = $info->getPath();
                $filename = $info->getFilename();
                //$root = request()->domain();
                $save_name = $info->getSaveName();
                if(__ROOT__){
                    $realpath =  __ROOT__.'/uploads/' . $save_name;
                }else{
                    $realpath =  '/uploads/' . $save_name;
                }
                exit(json_encode(['status' => 1, 'path' => $realpath, 'save_name' => $save_name]));
            } else {
                // 上传失败获取错误信息
                exit(json_encode(['status' => 1, 'error' => $file->getError()]));
            }
        } elseif (request()->isGet()) {
            //删除图片
            $real_path = request()->get('path');
            $path = ROOT_PATH . 'public/uploads/' . $real_path;
            if (unlink($path)) {
                exit(json_encode(['status' => 1, 'msg' => '删除成功']));
            } else {
                exit(json_encode(['status' => 0, 'msg' => '删除成功']));
            }
        }
    }

    /**
    **  富文本框图片上传
    **/

    public function uploadEditor(){
        $file = request()->file('imgFile');
            $info = $file->move(ROOT_PATH . 'public/uploads');
            if ($info) {
                // 成功上传后 获取上传信息
                $path = $info->getPath();
                $filename = $info->getFilename();
                //$root = request()->domain();
                $save_name = $info->getSaveName();
                if(__ROOT__){
                    $realpath =  __ROOT__.'/uploads/' . $save_name;
                }else{
                    $realpath =  '/uploads/' . $save_name;
                }
                exit(json_encode(['error' => 0, 'url' => $realpath]));
            } else {
                // 上传失败获取错误信息
                exit(json_encode(['error' => 1, 'message' => $file->getError()]));
            }
    }

}
