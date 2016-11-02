<?php
/**
 * Created by PhpStorm.
 * User: WANG
 * Date: 2016-08-11
 * Time: 9:58
 */

namespace app\common\taglib;

use think\template\TagLib;
use think\Db;

class Tag extends TagLib
{
    /**
     * 定义标签列表
     */
    protected $tags = [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'web' => ['attr' => 'name', 'close' => 0],
        'nav' => ['attr' => 'pid,limit,orderby'],
        'product' => ['attr' => 'cid,field,orderby,limit,pagesize'],
        'article' => ['attr' => 'cid,field,orderby,limit,pagesize,empty'],
        'archived' => ['close' => 1]

    ];


    public function tagWeb($tag){
        $name = $tag['name'];
        $parse = <<<EOF
        <?php
                \$name = think\Db::name('system')->where(['name'=> 'site_$name'])->value('value');
                echo \$name;
                ?>
EOF;
        return $parse;
    }
    /**
     * 获取导航列表
     */
    public function tagNav($tag, $content)
    {
        $pid = $tag['pid'];
        $limit = isset($tag['limit']) ? $tag['limit'] : 0;

        $parse = <<<EOF
        <?php
               \$__LIST__ = getAllCategory(0,"$pid","$limit");

                foreach(\$__LIST__ as \$key => \$nav):
                ?>
EOF;

        $parse .= $content;
        $parse .= '<?php endforeach; ?>';
        return $parse;
    }

    /**
     * 获取文章归档列表
     */
    public function tagArchived($tag, $content)
    {
        $parse = <<<EOF
        <?php
               \$__LIST__ = think\Db::name('article')
                ->field("FROM_UNIXTIME(publishtime,'%Y-%m') as date,count(id) as count")
                ->where('status',0)
                ->group('date')
                ->order('date DESC')
                ->select();

                foreach(\$__LIST__ as \$key => \$archived):
                \$archived['url'] = url('search/search4Date',['date' => \$archived['date']]);
                ?>
EOF;

        $parse .= $content;
        $parse .= '<?php endforeach; ?>';
        return $parse;
    }

    /**
     * 获取商品列表
     */
    public function tagProduct($tag, $content)
    {
        $cid = isset($tag['cid']) ? $tag['cid'] : 0;
        $order = isset($tag['orderby']) ? $tag['orderby'] : '';
        $limit = isset($tag['limit']) ? $tag['limit'] : 0;
        $pagesize = isset($tag['pagesize']) ? $tag['pagesize'] : 0;
        $field = isset($tag['field']) ? $tag['field'] : '';

        $parse = <<<EOF
        <?php
                \$list = think\Db::name('product')->where(['cid'=> $cid,'status' => 0]);
                if("$field" != ''){
                    \$list=\$list->field("$field");
                }

                if("$order" != ''){
                    \$list=\$list->order("$order");
                }

                if($pagesize > 0){
                    \$list=\$list->paginate($pagesize);
                    \$page = \$list->render();
                }else{
                    if($limit != 0){
                        \$list=\$list->limit($limit);
                    }
                    \$list=\$list->select();

                }

                \$__LIST__ = \$list;
                foreach(\$__LIST__ as \$key => \$product):
                    \$product['url'] = url('index/show/index',['cid' => \$product['cid'],'id' => \$product['id']]);
                ?>
EOF;

        $parse .= $content;
        $parse .= '<?php endforeach; ?>';
        return $parse;
    }

    /**
     * 获取文章列表
     */
    public function tagArticle($tag, $content)
    {
        $cid = isset($tag['cid']) ? $tag['cid'] : 0;
        $order = isset($tag['orderby']) ? $tag['orderby'] : '';
        $limit = isset($tag['limit']) ? $tag['limit'] : 0;
        $pagesize = isset($tag['pagesize']) ? $tag['pagesize'] : 0;
        $field = isset($tag['field']) ? $tag['field'] : '';
        $empty = isset($tag['empty']) ? $tag['empty'] : '';
        /*$children_ids = Db::name('category')->where('pid',$cid)->field('id')->select();
        print_r(array_column($children_ids,'id'));die;*/
        $parse = <<<EOF
        <?php
                \$condition['status'] = 0;

                /*存在子类，则获取子类下的文章*/
                if($cid){
                    \$condition['cid'] = $cid;
                    \$children_ids = think\Db::name('category')->field('id')->where('pid',\$condition['cid'])->select();
                    \$children_ids = array_column(\$children_ids,'id');
                }
                \$list = think\Db::name('article')->where(\$condition);
                if(isset(\$children_ids) && \$children_ids){
                     \$list = \$list->whereor('cid','in',\$children_ids);
                 }

                if("$field" != ''){
                    \$list=\$list->field("$field");
                }

                if("$order" != ''){
                    \$list=\$list->order("$order");
                }

                if($pagesize > 0){
                    \$list=\$list->paginate($pagesize);
                    \$page = \$list->render();
                }else{
                    if($limit != 0){
                        \$list=\$list->limit($limit);
                    }
                    \$list=\$list->select();

                }

                \$__LIST__ = \$list;
                foreach(\$__LIST__ as \$key => \$article):
                \$article['url'] = url('index/show/index',['cid' => \$article['cid'],'id' => \$article['id']]);
                ?>
EOF;

        $parse .= $content;
        $parse .= '<?php endforeach;?>';
        return $parse;
    }
}