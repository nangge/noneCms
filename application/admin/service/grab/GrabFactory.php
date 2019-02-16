<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2019/2/15
 * Time: 下午4:39
 */

namespace app\admin\service\grab;


class GrabFactory
{

    private static $rules = [
        'blog.csdn.net' => 'CSDN',
        'juejin.im' => 'JJ',
        'tw.v2ex.com' => 'V2EX',
        'blog.51cto.com' => 'CTO51',
        'www.cnblogs.com' => 'CnBlog',
        'blog.gitee.com' => 'Gitee',
    ];

    /**
     * @param $url
     *
     * @return Base
     */
    public static function get($url)
    {
        $urlArr = explode('/', $url);
        if ($urlArr[2] && array_key_exists($urlArr[2], self::$rules)) {
            $className = '\\app\\admin\\service\\grab\\' . self::$rules[$urlArr[2]];
            return new $className($url);
        }
        raise(9100, '暂时不支持该网站的文章转载', ['url' => $urlArr]);
    }
}