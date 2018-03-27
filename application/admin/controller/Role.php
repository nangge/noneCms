<?php
/**
 * 角色管理
 * 
 */
namespace app\admin\controller;

use app\admin\model\Category;
use app\common\model\AdminRole;
use think\facade\Config;
use think\Db;
use think\Loader;
use think\facade\Cache;
use think\Validate;

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
            $validate = new Validate([
               'name'=>'require|token',
            ]);
            if (!$validate->check($data)) {
                exit(json_encode(['status' => 0, 'msg' => $validate->getError()]));
            }

            $role = new AdminRole();
            if ($role->data($data,true)->save()) {
                return ['status' => 1, 'msg' => '添加成功'];
            } else {
                return ['status' => 0, 'msg' => '添加失败，请稍后重试'];
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
            $validate = new Validate([
                'name'=>'require|token',
            ]);
            if (!$validate->check($data)) {
                exit(json_encode(['status' => 0, 'msg' => $validate->getError()]));
            }

            $role = new AdminRole();
            if (false !== $role->save($data,['id' => $data['id']])) {
                //清除缓存
                Cache::clear('auth');
                return ['status' => 1, 'msg' => '更新成功'];
            } else {
                return ['status' => 0, 'msg' => '更新失败，请稍后重试'];
            }
            
        } else {
            $find = AdminRole::get($id);
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
        $role = AdminRole::get($id);
        if ($role && $role->delete()) {
            return ['status' => 1, 'msg' => '删除成功'];
        } else {
            return ['status' => 0, 'msg' => '删除失败'];
        }
    }
}
