<?php
/**
 *产品模型
 */

namespace app\admin\controller;

use app\common\model\Category;
use think\facade\Config;
use think\Controller;
use think\Db;
use think\facade\Env;
use think\facade\Request;
use think\facade\Session;

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
        $pc_theme = get_system_value('site_theme');
        $mobile_theme = get_system_value('site_mobile_theme');
        $this->assign(['pc_theme' => $pc_theme,'mobile_theme' => $mobile_theme]);
        $this->assign('product_count',$product_count);
        $this->assign('article_count',$article_count);
        //获取单页栏目
        $single_page = Category::where('modelid', 2)->field('id,name,ename')->select();
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
        $act = input('act');
        if ($act === 'add') {
            $file = request()->file('pic_url');
            $info = $file
                ->validate(['size'=> 1024*1024*2,'ext'=>['jpg', 'png', 'jpeg', 'gif', 'bmp']])
                ->move(Env::get('root_path') . 'public/uploads');
            if ($info) {
                // 成功上传后 获取上传信息
                $save_name = $info->getSaveName();
                $realpath =  __ROOT__.'/uploads/' . $save_name;
                exit(json_encode(['status' => 1, 'path' => $realpath, 'save_name' => $save_name, 'param' => input('?param.act')]));
            } else {
                // 上传失败获取错误信息
                exit(json_encode(['status' => 0, 'msg' => $file->getError()]));
            }
        }
        // 删除图片
        if ($act === 'del') {
            $img_dir = input('path');
            if (substr($img_dir,0,9) !== '/uploads/') {
                exit(json_encode(['status' => 0, 'msg' => '文件路径不合法']));
            }
            if (strpos($img_dir, '../') || strpos($img_dir, './')) {
                exit(json_encode(['status' => 0, 'msg' => '文件路径不合法']));
            }
            $path = str_replace(['/..\/','/../'],'/',Env::get('root_path') . 'public' . $img_dir);
            if (@unlink($path)) {
                exit(json_encode(['status' => 1, 'msg' => '删除成功']));
            } else {
                exit(json_encode(['status' => 0, 'msg' => '删除失败' ,'path' => $path, 'real_path' => $img_dir, 'env' => Env::get('root_path')]));
            }
        }
        exit(json_encode(['status' => 0, 'msg' => '操作不合法']));
    }

    /**
    **  富文本框图片上传
    **/

    public function uploadEditor(){
        $file = request()->file('editormd-image-file');
        $info = $file->validate(['size'=> 1024*1024*2,'ext'=>['jpg', 'png', 'jpeg', 'gif', 'bmp']])->move(Env::get('root_path') . 'public/uploads');
        if ($info) {
            // 成功上传后 获取上传信息
            $save_name = $info->getSaveName();
            $realpath =  __ROOT__.'/uploads/' . $save_name;
            exit(json_encode(['error' => 0, 'success' => 1, 'url' => $realpath]));
        } else {
            // 上传失败获取错误信息
            exit(json_encode(['error' => 1, 'success' => 0, 'message' => $file->getError()]));
        }
    }

}
