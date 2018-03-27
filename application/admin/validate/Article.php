<?php
/**
 * Created by Wang.
 * User: nango
 * Date: 2018-01-03
 * Time: 14:08
 */
namespace app\admin\validate;
use think\Validate;

class Article extends Validate {
    protected $rule =   [
        'title'  => 'require|max:60|token',
        'cid' => 'require',
        'content' => 'require',
    ];

    protected $message  =   [
        'title.require' => '文章标题不能为空',
        'title.max'     => '文章标题最多不能超过60个字符',
        'cid.require'   => '请先选择文章分类',
        'content.require'   => '请填写文章内容',
    ];

}
