<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2019/2/15
 * Time: 下午1:48
 */

namespace app\admin\service\grab;


use think\Exception;

class CSDN extends Base
{

    protected $domain = 'https://blog.csdn.net/';

    protected $titleElementArr = [
        '.link_title',
        '.title-article',
        '.list_c_t a',
        'h1.csdn_top',
    ];

    protected $contentElementArr = [
        '#article_content'
    ];

}