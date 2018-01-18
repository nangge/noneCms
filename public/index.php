<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think;

// 加载基础文件
use think\facade\Request;

require __DIR__ . '/../thinkphp/base.php';
if(!file_exists(__DIR__ . '/../config/database.php')){
    header('Content-Type:text/html;charset=UTF-8');
    echo '请先安装本程序！运行public目录下，install文件夹下index.php即可安装！';exit;
}

// 支持事先使用静态方法设置Request对象和Config对象

define('__ROOT__',str_replace('/index.php','',Request::root()));
// 执行应用并响应
Container::get('app')->run()->send();

