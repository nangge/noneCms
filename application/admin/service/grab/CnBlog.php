<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2019/2/15
 * Time: 下午5:09
 */

namespace app\admin\service\grab;


class CnBlog extends Base
{
    protected $domain = 'https://www.cnblogs.com/';

    protected $titleElementArr = [
        '.postTitle a'
    ];

    protected $contentElementArr = [
        '.postBody'
    ];
}