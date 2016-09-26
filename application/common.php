<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/*
 * 获取所有导航
 * @param $status mixed 是否显示||全部
 * @param $limit mixed
 * @param $pid int 父级id 0则为顶级栏目
 */
function getAllCategory($status, $pid = '', $limit = '')
{
    //导航
    $nav = think\Db::name('category');

    if ($status !== 'all') {
        $nav = $nav->where(['status' => $status]);
    }

    //pid为空则会获取所有导航并且拼装二级，其他值则只能获取该父id下的导航
    if ($pid !== '') {
        $nav = $nav->where(['pid' => $pid]);
    }

    if ($limit != '') {
        $nav = $nav->limit($limit);
    }
    $nav = $nav->select();
    $all_nav = [];
    //拼接导航 一级二级
    foreach ($nav as $key => $val) {
        //生成url，前端
        $val['url'] = url('index/listing/index', ['cid' => $val['id']]);
        if ($val['pid'] == 0) {
            $all_nav[$val['id']] = $val;
        } else {
            $all_nav[$val['pid']]['children'][] = $val;
        }
    }

    return $all_nav;
}

/**
 * 对用户的密码进行加密
 * @param $password
 * @param $encrypt //传入加密串，在修改密码时做认证
 * @return array/password
 */
function get_password($password, $encrypt='') {
    $pwd = array();
    $pwd['encrypt'] =  $encrypt ? $encrypt : get_randomstr();
    $pwd['password'] = md5(md5(trim($password)).$pwd['encrypt']);
    return $encrypt ? $pwd['password'] : $pwd;
}

/**
 * 生成随机字符串
 */
function get_randomstr($length = 6) {
    $chars = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
    $hash = '';
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

/**
 * 获取system配置参数
 */
function get_system_value($name=''){
    $value = think\Db::name('system')->where('name',$name)->value('value');
    return $value;
}