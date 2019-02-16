<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2019/2/15
 * Time: 下午5:05
 */

namespace app\admin\service\grab;


class CTO51 extends Base
{
    protected $domain = 'http://blog.51cto.com/';

    protected $titleElementArr = [
        'h1.artical-title',
    ];

    protected $contentElementArr = [
        '.main-content'
    ];
}