<?php
/**
 * 单页控制器
 */
namespace app\admin\controller;

use think\Db;

class Flink extends Common
{
	private static $_table = 'flink';

	/**
	 * 友情链接管理界面
	 * @return 
	 */
    public function index()
    {
        $list = Db::name(self::$_table)->where(['status' => 0,'type' => 1])->order('id DESC')->paginate(20);
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
        $list = Db::name(self::$_table)->where(['status' => 0,'type' => 2])->order('id DESC')->paginate(20);
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
				if ($params['title'] == '') {
	            	exit(json_encode(['status' => 0, 'msg' => '请填写公告标题', 'url' => '']));
	            }
            }else{
            	if ($params['title'] == '') {
            		exit(json_encode(['status' => 0, 'msg' => '请填写网站名称', 'url' => '']));
	            }

	            if ($params['url'] == '') {
	            	exit(json_encode(['status' => 0, 'msg' => '请填写网站url', 'url' => '']));
	            }
            }
            

			if (isset($params['pic_url'])) {
                $params['logo'] = implode('|',$params['pic_url']);
                unset($params['pic_url']);
            }else{
            	$params['logo'] = '';
            }
            
            //新增
            unset($params['id']);
            $params['create_time'] = strtotime("now");
            
            $flag = Db::name(self::$_table)->insert($params);
            if ($flag) {
                exit(json_encode(['status' => 1, 'msg' => '添加成功', 'url' => url('flink/index')]));
            } else {
                exit(json_encode(['status' => 0, 'msg' => '添加失败', 'url' => '']));
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
            $data = Db::name(self::$_table)->where(['id' => $id])->find();
            $this->assign('item',$data);
            if (input('?type') && input('param.type/d') == 2){
                return $this->fetch('annedit');
            }else{
                return $this->fetch();
            }
        } elseif (request()->isPost()) {
            $params = input('post.');
            if ($params['type'] == 2){
                if ($params['title'] == '') {
                    exit(json_encode(['status' => 0, 'msg' => '请填写公告标题', 'url' => '']));
                }
            }else{
                if ($params['title'] == '') {
                    exit(json_encode(['status' => 0, 'msg' => '请填写网站名称', 'url' => '']));
                }

                if ($params['url'] == '') {
                    exit(json_encode(['status' => 0, 'msg' => '请填写网站url', 'url' => '']));
                }
            }
            

            if (isset($params['pic_url'])) {
                $params['logo'] = implode('|',$params['pic_url']);
                unset($params['pic_url']);
            }else{
                $params['logo'] = '';
            }
            
             //更新
            $id = $params['id'];
            unset($params['id']);
            $url = $params['type'] == 1?url('flink/index'):url('flink/annindex');
            $flag = Db::name(self::$_table)->where(['id' => $id])->update($params);
            if ($flag !== false) {
                exit(json_encode(['status' => 1, 'msg' => '更新成功', 'url' => $url]));
            } else {
                exit(json_encode(['status' => 0, 'msg' => '更新失败，请稍后重试', 'url' => '']));
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
        $flag = Db::name(self::$_table)->where(['id' => $id])->update(['status' => 1]);
        if ($flag) {
            echo '删除成功';
        } else {
            echo '删除失败';
        }
    }


}
