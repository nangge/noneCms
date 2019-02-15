<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2019/2/15
 * Time: 下午4:26
 */

namespace app\admin\service\grab;


class JJ extends Base
{
    protected $domain = 'https://juejin.im/';

    protected $titleElementArr = [
        '.article-title',
    ];

    protected $contentElementArr = [
        '.article-content'
    ];
}