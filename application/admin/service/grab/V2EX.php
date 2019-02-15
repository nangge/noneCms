<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2019/2/15
 * Time: 下午5:01
 */

namespace app\admin\service\grab;


class V2EX extends Base
{
    protected $domain = 'https://tw.v2ex.com/';

    protected $titleElementArr = [
        '.header h1',
    ];

    protected $contentElementArr = [
        '.topic_content'
    ];
}