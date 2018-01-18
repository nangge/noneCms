<?php
/**
 * Created by Wang.
 * User: nango
 * Date: 2018-01-05
 * Time: 14:08
 */
namespace app\admin\validate;
use think\Validate;

class Product extends Validate {
    protected $rule =   [
        'title'  => 'require|max:60',
        'cid' => 'require',
        'content' => 'require',
    ];

    protected $message  =   [
        'title.require' => '标题不能为空',
        'title.max'     => '标题最多不能超过60个字符',
        'cid.require'   => '请先选择分类',
        'content.require'   => '请填写内容',
    ];

}
