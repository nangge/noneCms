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
        'close' => ['attr' => 'time,format', 'close' => 0], //闭合标签，默认为不闭合
        'open' => ['attr' => 'name,type', 'close' => 1],
        'web' => ['attr' => 'name', 'close' => 0],
        'nav' => ['attr' => 'pid,limit,orderby'],
        'product' => ['attr' => 'cid,field,orderby,limit,pagesize'],
        'article' => ['attr' => 'cid,field,orderby,limit,pagesize,empty'],
        'archived' => ['close' => 1]

    ];

    /**
     * 这是一个闭合标签的简单演示
     */
    public function tagClose($tag)
    {
        $format = empty($tag['format']) ? 'Y-m-d H:i:s' : $tag['format'];
        $time = empty($tag['time']) ? time() : $tag['time'];
        $parse = '<?php ';
        $parse .= 'echo date("' . $format . '",' . $time . ');';
        $parse .= ' ?>';
        return $parse;
    }

    /**
     * 这是一个非闭合标签的简单演示
     */
    public function tagOpen($tag, $content)
    {
        $type = empty($tag['type']) ? 0 : 1; // 这个type目的是为了区分类型，一般来源是数据库
        $name = $tag['name']; // name是必填项，这里不做判断了

        $parse = '<?php ';
        $parse .= '$test_arr=[[1,3,5,7,9],[2,4,6,8,10]];'; // 这里是模拟数据
        $parse .= '$list = think\Db::name(\'product\')->where(\'cid\',1)->select();';
        $parse .= '$__LIST__ = $list;';
        $parse .= '?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

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
                    \$product['url'] = url('show/index',['cid' => \$product['cid'],'id' => \$product['id']]);
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
                \$article['url'] = url('show/index',['cid' => \$article['cid'],'id' => \$article['id']]);
                ?>
EOF;

        $parse .= $content;
        $parse .= '<?php endforeach;?>';
        return $parse;
    }
}