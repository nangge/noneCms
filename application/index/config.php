<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-08-03
 * Time: 13:30
 */
$root = request()->root();
define('__ROOT__',str_replace('/index.php','',$root));
return [
    // 应用调试模式
    'app_debug'              => false,
    // 视图
    'template'               => [
        'view_path'    => './template/'.get_system_value('site_theme').'/',
        'view_depr'    => '_',
        // 预先加载的标签库
        'taglib_pre_load'     =>    'app\common\taglib\Tag',
        'taglib_build_in'     =>    'app\common\taglib\Tag,cx',
    ],
    // 视图输出字符串内容替换
    'view_replace_str'       => [
        '__PUBLIC__' => __ROOT__.'/template/'.get_system_value('site_theme'),
        '__COMMON__' => __ROOT__.'/static/common'
    ],
];