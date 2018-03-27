<?php
/**
 * Created by PhpStorm.
 * User: nango
 * Date: 2018/1/3
 * Time: 16:11
 */

namespace app\admin\validate;

use think\Validate;

class Banner extends Validate {
    protected $rule = [
        'title' => 'require|max:25|token',
    ];

    protected $message = [
        'title.require' => '标题不能为空',
        'title.max' => '标题最多不能超过25个字符',
    ];
}