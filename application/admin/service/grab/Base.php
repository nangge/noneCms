<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2019/2/15
 * Time: 下午1:49
 */

namespace app\admin\service\grab;

/**
 * Class Base 页面抓取基类
 */
abstract class Base
{

    /**
     * 是否需要登陆
     *
     * @var bool
     */
    protected $needLogin = false;

    /**
     * 网站域名
     *
     * @var string
     */
    protected $domain = '';

    /**
     * 页面地址
     *
     * @var string
     */
    private $url = '';

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    protected function checkUrl()
    {
        if (strpos($this->getUrl(), $this->domain) === 0) {
            return true;
        }
        return false;
    }

    abstract function parse();
}