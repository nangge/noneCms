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

    /**
     * 配制文章标题可能的元素
     *
     * @var array
     */
    private $titleElementArr = [
        '.link_title',
        '.title-article',
        '.list_c_t a',
        'h1.csdn_top',
    ];

    /**
     * 配制文章内容可能的元素
     *
     * @var array
     */
    private $contentElementArr = [
        '#article_content'
    ];

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
    private function getTitle()
    {
        $title = '';
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
    private function getContent()
    {
        $content = '';
        foreach ($this->contentElementArr as $item) {
            $content = pq($item)->text();
            if ($content) {
                break;
            }
        }
        return $content;
    }
}