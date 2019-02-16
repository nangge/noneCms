<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2019/2/15
 * Time: 下午5:18
 */

namespace app\admin\service\grab;


class Gitee extends Base
{
    protected $domain = 'https://blog.gitee.com/';

    protected $titleElementArr = [
        '.content h1'
    ];

    protected $contentElementArr = [
        '.row .l-main'
    ];
}