<?php
/**
 * 角色管理
 * 
 */
namespace app\admin\controller;

use app\admin\model\Category;
use think\Config;
use think\Db;
use think\Loader;
use think\Cache;

class Role extends Common
{

    public function index()
    {
        $list = Db::name('admin_role')->field('id,name,createtime,remark')->select();
        $this->assign('list', $list);
        return $this->fetch();
    }

    /*
     * 添加角色
     */
    public function add()
    {
        if (request()->isPost()) {
            $data = input('param.');
            if (!$data['name']) {
                exit(json_encode(['status' => 0, 'msg' => '角色名称不能为空']));
            }

            $data['createtime'] = time();
            $flag = Db::name('admin_role')->insert($data);
            
            if ($flag !== false) {
                exit(json_encode(['status' => 1, 'msg' => '添加成功']));
            } else {
                exit(json_encode(['status' => 0, 'msg' => '数据库操作失败，请稍后重试']));
            }
            
        } else {
            $power = Db::name('admin_power')->select();
            $powers = [];
            foreach ($power as $key => $value) {
                if ($value['parent'] == 0) {
                    $powers[$value['id']] = $value;
                } else {
                    $powers[$value['parent']]['children'][] = $value;
                }
            }
            $this->assign('powers', $powers);
            return $this->fetch();
        }
    }

    /**
     * 修改角色信息
     */
    public function edit($id)
    {
        if (request()->isPost()) {
            $data = input('param.');
            if (!$data['name']) {
                exit(json_encode(['status' => 0, 'msg' => '角色名称不能为空']));
            }

            //更新
            $id = $data['id'];
            unset($data['id']);
            $flag = Db::name('admin_role')->where('id', $id)->update($data);

            if ($flag !== false) {
                //清除缓存
                Cache::clear('auth');
                exit(json_encode(['status' => 1, 'msg' => '']));
            } else {
                exit(json_encode(['status' => 0, 'msg' => '数据库操作失败，请稍后重试']));
            }
            
        } else {
            $find = Db::name('admin_role')->where('id', $id)->find();
            if (!$find) {
                return;
            } else if ($find['power']) {
                $array = array();
                $split = explode(',', $find['power']);
                for ($i = 0; $i < count($split); $i++) {
                    $array[$split[$i]] = $split[$i];
                }
                $find['power'] = $array;
            }

            $power = array();
            $list = Db::name('admin_power')->select();
            foreach ($list as $key => $val) {
                
                $parent = $val['parent'];
                $id = $val['id'];
                if (isset($find['power'][$val['id']]) && !empty($find['power'][$val['id']])) {
                    $val['checked'] = true;
                } else {
                    $val['checked'] = false;
                }
                if ($parent == 0) {
                    $power[$id] = $val;
                } else {
                    $power[$parent]['sub'][$id] = $val;
                }
            }
            $this->assign('power', $power);
            $this->assign('find', $find);
            return $this->fetch();
        }
    }

    /**
     * 删除角色信息
     */
    public function dele()
    {
        $id = input('param.id/d',0);
        $flag = Db::name('admin_role')->delete($id);
        if ($flag) {
            exit(json_encode(['status' => 1, 'msg' => '删除成功']));
        } else {
            exit(json_encode(['status' => 0, 'msg' => '删除失败']));
        }
    }
}
