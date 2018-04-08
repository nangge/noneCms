#! user/bin/env php
<?php
define('APP_PATH', __DIR__ . '/application/');

// 加载基础文件
require __DIR__ . '/thinkphp/base.php';

// 执行应用并响应
\think\Container::get('app',[APP_PATH])->bind('push/worker_chat')->run()->send();
?>