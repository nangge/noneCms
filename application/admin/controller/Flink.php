<?php
/**
 * 单页控制器
 */
namespace app\admin\controller;

use think\Db;
use app\common\model\Flink as flinkModel;
use think\Validate;

class Flink extends Common
{
	private static $_table = 'flink';

	/**
	 * 友情链接管理界面
	 * @return 
	 */
    public function index()
    {
        $list = flinkModel::where(['status' => 0,'type' => flinkModel::TYPE_LINK])->order('id DESC')->paginate(20);
        $this->assign('page',$list->render());
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * 公告管理界面
     * @return 
     */
	public function annindex()
    {
        $list = flinkModel::where(['status' => 0,'type' => flinkModel::TYPE_COMMENT])->order('id DESC')->paginate(20);
        $this->assign('page',$list->render());
        $this->assign('list', $list);
        return $this->fetch();
    }

     /**
     * 添加友链/公告
     *
     */
    public function add()
    {
        //显示页面
        if (request()->isGet()) {
        	if (input('?type') && input('param.type') == 2){
        		return $this->fetch('annadd');
        	}
            return $this->fetch();
        } elseif (request()->isPost()) {
            $params = input('post.');
            if ($params['type'] == 2){
                $validate = new Validate([
                   'title'=>'require|token'
                ]);
                if(!$validate->check($params)){
                    return ['status' => 0, 'msg' => '请填写公告标题', 'url' => ''];
                }
            }else{
                $validate = new Validate([
                    'title'=>'require|token',
                    'url'=>'require'
                ]);
                if(!$validate->check($params)){
                    return ['status' => 0, 'msg' => $validate->getError(), 'url' => ''];
                }
            }

            $flink = new flinkModel();
            if ($flink->data($params,true)->save()) {
                return ['status' => 1, 'msg' => '添加成功', 'url' => url('flink/index')];
            } else {
                return ['status' => 0, 'msg' => '添加失败', 'url' => ''];
            }
        }
    }

    /*
     * 更新友链信息
     *
     * $id 资源id
     */
    public function edit() {
        //显示页面
        if (request()->isGet()) {
            $id = input('param.id/d',0);
            $this->assign('item',flinkModel::get($id));
            if (input('?type') && input('param.type/d') == 2){
                return $this->fetch('annedit');
            }else{
                return $this->fetch();
            }
        } elseif (request()->isPost()) {
            $params = input('post.');
            if ($params['type'] == 2){
                $validate = new Validate([
                    'title'=>'require|token'
                ]);
                if(!$validate->check($params)){
                    return ['status' => 0, 'msg' => '请填写公告标题', 'url' => ''];
                }
            }else{
                $validate = new Validate([
                    'title'=>'require|token',
                    'url'=>'require'
                ]);
                if(!$validate->check($params)){
                    return ['status' => 0, 'msg' => $validate->getError(), 'url' => ''];
                }
            }

            $url = $params['type'] == 1?url('flink/index'):url('flink/annindex');
            $flink = new flinkModel();
            if (false !== $flink->save($params,['id' => $params['id']])) {
                return ['status' => 1, 'msg' => '更新成功', 'url' => $url];
            } else {
                return ['status' => 0, 'msg' => '更新失败，请稍后重试', 'url' => ''];
            }
        }
    	
        
    }

    /**
     * 删除友链、公告
     * @return [type] [description]
     */
    public function dele() {
        $id = input('param.id/d',0);
        //逻辑删除
        $flink = new flinkModel();
        if ($flink->save(['status' => 1],['id' => $id])) {
            return ['status' => 1, 'msg' => '删除成功'];
        } else {
            return ['status' => 1, 'msg' => '删除失败'];
        }
    }


}
