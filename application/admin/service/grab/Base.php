<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2019/2/15
 * Time: 下午1:49
 */

namespace app\admin\service\grab;

use think\Exception;

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
     * 配制文章标题可能的元素
     *
     * @var array
     */
    protected $titleElementArr = [];

    /**
     * 配制文章内容可能的元素
     *
     * @var array
     */
    protected $contentElementArr = [];

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

    public function __construct($url)
    {
        $this->setUrl($url);
        $this->init();
    }

    protected function init()
    {
        if (!$this->checkUrl()){
            raise(9011, '地址不正确');
        }
        \phpQuery::newDocumentFile($this->getUrl());
    }

    public function parse()
    {
        try {
            $title = $this->getTitle();
            if (mb_strlen($title, 'utf-8') > 60) {
                raise(0, '转载失败,文章标题超过60字');
            }
            $content = $this->getContent();
            // 如果抓取不到主内容
            if (!$content) {
                raise(9013, '文章不存在');
            }
            $params['content'] = $content;
            $params['title'] = $title;
            $params['publishtime'] = '';
            $params['description'] = trim(strip_tags($content));
            $params['copyfrom'] = $this->getUrl();
            return $params;
        } catch (Exception $e) {
            $msg = '文章不存在';
            raise(9015, $msg);
        }
    }

    /**
     * 获取文章标题
     *
     * @return String
     */
    protected function getTitle()
    {
        $title = '';
        if (empty($this->titleElementArr)) {
            return $title;
        }
        foreach ($this->titleElementArr as $item) {
            $title = pq($item)->text();
            if ($title) {
                break;
            }
        }
        return $title;
    }

    /**
     * 获取文章内容
     *
     * @return String
     */
    protected function getContent()
    {
        $content = '';
        if (empty($this->contentElementArr)) {
            return $content;
        }
        foreach ($this->contentElementArr as $item) {
            $content = pq($item)->text();
            if ($content) {
                break;
            }
        }
        return $content;
    }
}