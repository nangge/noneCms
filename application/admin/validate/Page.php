<?php
/**
 * Created by Wang.
 * User: nango
 * Date: 2018-01-06
 * Time: 14:08
 */
namespace app\admin\validate;
use think\Validate;

class Page extends Validate {
    protected $rule =   [
        'cid' => 'require',
        'content' => 'require',
    ];

    protected $message  =   [
        'cid.require'   => '请先选择分类',
        'content.require'   => '请填写内容',
    ];

}
