<?php
/**
 * 单页控制器
 */
namespace app\admin\controller;

use app\common\model\AdminRole;
use app\common\model\Admin as adminModel;

class Admin extends Common
{

    /**
     * 管理员首页
     * @return mixed
     */
    public function index()
    {
        $list = adminModel::where('islock', '<>', adminModel::ISLOCK_YES)->select();

        foreach ($lista as &$admin) {
            $admin->name = $admin->role_id ? $admin->role->name : '';
        }

        $this->assign('list', $list);
        return $this->fetch();
    }

    /*
     * 添加用户
     */
    public function add()
    {
        if (request()->isPost()) {
            //修改处理
            $params = input('post.');

            //验证规则
            $result = $this->validate($params, 'app\admin\validate\Admin');
            if ($result !== true) {
                return ['status' => 0, 'msg' => $result, 'url' => ''];
            }


            $params['encrypt'] = get_randomstr();//6位hash值
            $params['password'] = get_password($params['password'], $params['encrypt']);
            $admin = new adminModel();
            if ($admin->data($params, true)->save()) {
                return ['status' => 1, 'msg' => '添加成功', 'url' => url('admin/index')];
            } else {
                return ['status' => 0, 'msg' => '添加失败,请稍后重试', 'url' => ''];
            }
        } else {
            $this->assign('role', AdminRole::all());
            return $this->fetch();
        }
    }

    /**
     * 修改用户信息
     */
    public function edit($id)
    {
        if (request()->isPost()) {

            $params = input('post.');

            //验证规则
            $result = $this->validate($params, 'app\admin\validate\Admin.edit');
            if ($result !== true) {
                return ['status' => 0, 'msg' => $result, 'url' => ''];
            }

            $admin = adminModel::get($params['id']);
            $admin->username = $params['username'];
            $admin->email = $params['email'];
            $admin->role_id = $params['role_id'];
            $admin->islock = $params['islock'];

            if (!empty($params['password'])) {
                $admin->encrypt = get_randomstr();//6位hash值
                $admin->password = get_password($params['password'], $admin->encrypt);
            }


            if (false !== $admin->save()) {
                return ['status' => 1, 'msg' => '修改成功', 'url' => url('admin/index')];
            } else {
                return ['status' => 0, 'msg' => '修改失败,请稍后重试', 'url' => ''];
            }
        } else {
            $this->assign([
                'role' => AdminRole::all(),
                'data' => adminModel::get($id)
            ]);
            return $this->fetch();
        }
    }

    /**
     * 删除用户信息
     */
    public function dele()
    {
        $id = input('param.id/d', 0);
        $admin = adminModel::get($id);
        $admin->islock = adminModel::ISLOCK_YES;
        if ($admin->save()) {
            return ['status' => 1, 'msg' => '删除成功'];
        } else {
            return ['status' => 0, 'msg' => '删除失败'];
        }
    }
}
