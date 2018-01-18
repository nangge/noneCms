<?php
/**
 * 单页控制器
 */
namespace app\admin\controller;

use app\common\model\Banner as bannerModel;
use app\common\model\BannerDetail;
use think\Db;

class Banner extends Common
{

    public function index()
    {
        $banner = bannerModel::all(['status' => 0]);
        $this->assign('banner', $banner);
        return $this->fetch();
    }

    /**
     * 幻灯片、广告添加
     * @return array|mixed
     */
    public function add()
    {
        if (request()->isPost()) {
            //新增处理
            $params = input('post.');
            $result = $this->validate($params, 'app\admin\validate\Banner');

            if (true !== $result) {
                return ['status' => 0, 'msg' => $result, 'url' => ''];
            }

            $banner = new bannerModel();
            if ($banner->data($params, true)->save()) {
                return ['status' => 1, 'msg' => '添加成功', 'url' => url('banner/index')];
            } else {
                return ['status' => 0, 'msg' => '添加失败', 'url' => ''];
            }
        } else {
            return $this->fetch();
        }
    }

    /**
     * 修改
     * @return array|mixed
     */
    public function edit()
    {
        $id = input('param.id/d');
        $banner = bannerModel::get(['id' => $id, 'status' => 0]);

        if (request()->isPost()) {

            $params = input('post.');
            $result = $this->validate($params, 'app\admin\validate\Banner');

            if (true !== $result) {
                return ['status' => 0, 'msg' => $result, 'url' => ''];
            }

            $banner->title = $params['title'];
            $banner->type = $params['type'];
            $banner->start_time = $params['start_time'];
            $banner->end_time = $params['end_time'];

            if (false !== $banner->save()) {
                return ['status' => 1, 'msg' => '修改成功', 'url' => url('banner/index')];
            } else {
                return ['status' => 0, 'msg' => '修改失败', 'url' => ''];
            }
        } else {
            $this->assign('item', $banner);
            return $this->fetch();
        }
    }

    /**
     * 删除
     */
    public function dele($id)
    {
        $banner = bannerModel::get($id);
        $banner->status = 1;
        if ($banner->save()) {
            return ['status' => 1, 'msg' => '删除成功'];
        } else {
            return ['status' => 0, 'msg' => '删除失败'];
        }
    }

    /**
     * Banner 已添加图片列表
     * @return
     */
    public function banlist($id)
    {
        $cate = bannerModel::get($id);
        $this->assign([
            'list' => $cate->lists,
            'cate' => $cate
        ]);
        return $this->fetch();
    }

    /**
     * 添加banner内容
     */
    public function addDetail($id = 0)
    {
        if (request()->isAjax()) {
            //新增处理
            $params = input('post.');
            $bannerDetail = new BannerDetail();
            if ($bannerDetail->data($params, true)->save()) {
                return ['status' => 1, 'msg' => '添加成功', 'url' => url('banner/banlist')];
            } else {
                return ['status' => 0, 'msg' => '添加失败', 'url' => ''];
            }
        } else {
            $this->assign('pid', $id);
            return $this->fetch();
        }
    }

    /**
     * 编辑大图
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function editDetail()
    {
        if (request()->isPost()) {
            $params = input('post.');

            $bannerDetail = new BannerDetail();
            if (false !== $bannerDetail->save($params,['id' => $params['id']])) {
                return ['status' => 1, 'msg' => '修改成功', 'url' => url('banner/banlist')];
            } else {
                return ['status' => 0, 'msg' => '修改失败', 'url' => ''];
            }
        } else {
            $id = input('param.id/d', 0);
            $this->assign('item', BannerDetail::get($id));
            return $this->fetch();
        }
    }

    /**
     * 删除幻灯片图片
     * @param $id
     */
    public function deleDetail($id)
    {
        if (BannerDetail::destroy($id)) {
            echo '删除成功！';
        } else {
            echo '删除失败！';
        }
    }
}
