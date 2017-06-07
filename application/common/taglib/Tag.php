<?php
/**
 * Created by nango
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
        'nav' => ['attr' => 'pid,limit,orderby,type'],
        'product' => ['attr' => 'cid,field,orderby,limit,pagesize'],
        'article' => ['attr' => 'cid,field,orderby,limit,pagesize,empty'],
        'archived' => ['close' => 1],
        'anlink' => ['attr' => 'type,limit','close' => 1],
        'content' => ['attr' => 'id,field,length', 'close' => 0],
        'ann' => ['attr' => 'id,length', 'close' => 0],
        'banner' => ['attr' => 'id,limit'],
        'guestbook' => ['close' => 0],
        'position' => ['close' => 0]

    ];


    /**
     * 获取网站基本配置
     * @param array $tag [属性]
     * @return 
     */
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
     * 添加在线留言
     * @return string
     */
    public function tagGuestbook(){
        $parse = <<<EOF
        <?php
                \$guestbook = url('guestbook/add');
                echo \$guestbook;
                ?>
EOF;
        return $parse;
    }

    /**
     * 获取当前位置
     * @return string
     */
    public function tagPosition(){
        $parse = <<<EOF
        <?php
            \$iurl = url('index/index');
            \$position = "<a href='\$iurl'>首页</a>";
            /**栏目**/
            if(isset(\$cid)){
                \$url = url('index/listing/index',['cid' => \$cate['id']]);
                if(isset(\$id)){
                    \$position .= "-><a href='\$url'>".\$cate['name']."</a>";
                }else{
                    \$position .= "->".\$cate['name'];
                }
                
            }
            /**资源**/
            if(isset(\$id)){
                \$position .= "->".msubstr(strip_tags(\$title),0,5);
            }
            echo \$position;
        ?>
EOF;
        return $parse;
    }

    /**
     * 获取单页栏目某一字段的值
     * @param  [type] $tag [description]
     * @return [type]      [description]
     */
    public function tagContent($tag){
        $id = $tag['id'];
        $field = $tag['field'];
        $length = isset($tag['length'])?$tag['length']:0;
        $parse = <<<EOF
        <?php
                \$content = think\Db::name('category')->where(['id'=> $id])->value('$field');
                if ("$length" > 0){
                    \$content = msubstr(strip_tags(\$content),0,$length);
                }
                echo \$content;
                ?>
EOF;
        return $parse;
    }

    /**
     * 获取指定公告内容
     * @param  [type] $tag [description]
     * @return [type]      [description]
     */
    public function tagAnn($tag){
        $id = $tag['id'];
        $length = isset($tag['length'])?$tag['length']:0;
        $parse = <<<EOF
        <?php
                \$content = think\Db::name('flink')->where(['type' => 2,'id'=> $id])->value('description');
                if ("$length" > 0){
                    \$content = msubstr(strip_tags(\$content),0,$length);
                }
                echo \$content;
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
        $type = isset($tag['type']) ? $tag['type'] : 0;
        $parse = <<<EOF
        <?php
               \$__LIST__ = getAllCategory("$type","$pid","$limit");

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
        $module = request()->module();
        $parse = <<<EOF
        <?php
               \$__LIST__ = think\Db::name('article')
                ->field("FROM_UNIXTIME(publishtime,'%Y-%m') as date,count(id) as count")
                ->where('status',0)
                ->group('date')
                ->order('date DESC')
                ->select();

                foreach(\$__LIST__ as \$key => \$archived):
                \$archived['url'] = url('$module/search/search4Date',['date' => \$archived['date']]);
                ?>
EOF;

        $parse .= $content;
        $parse .= '<?php endforeach; ?>';
        return $parse;
    }

    /**
     * 获取产品列表
     */
    public function tagProduct($tag, $content)
    {
        $cid = isset($tag['cid']) ? $tag['cid'] : 0;
        $order = isset($tag['orderby']) ? $tag['orderby'] : '';
        $limit = isset($tag['limit']) ? $tag['limit'] : 0;
        $pagesize = isset($tag['pagesize']) ? $tag['pagesize'] : 0;
        $field = isset($tag['field']) ? $tag['field'] : '';
        $module = request()->module();
        $parse = <<<EOF
        <?php
                \$list = think\Db::name('product')->where(['status' => 0]);
                if ($cid != 0){
                    \$list=\$list->where(['cid'=> $cid]);
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
                foreach(\$__LIST__ as \$key => \$product):
                    \$product['url'] = url('$module/show/index',['cid' => \$product['cid'],'id' => \$product['id']]);
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
        $module = request()->module();
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
                     \$list = \$list->whereor(['cid' => ['in',\$children_ids], 'status' => 0]);
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
                \$article['url'] = url('$module/show/index',['cid' => \$article['cid'],'id' => \$article['id']]);
                ?>
EOF;

        $parse .= $content;
        $parse .= '<?php endforeach;?>';
        return $parse;
    }

    /**
     * 获取友情链接列表
     */
    public function tagAnlink($tag, $content)
    {
        $type = $tag['type'];
        $limit = isset($tag['limit']) ? $tag['limit'] : '';

        $parse = <<<EOF
        <?php
               \$__LIST__ = think\Db::name('flink')->where(['type'=> $type,'status' => 0]);
               if("$limit" != ''){
                        \$__LIST__=\$__LIST__->limit($limit);
                    }
                \$__LIST__=\$__LIST__->select();

                foreach(\$__LIST__ as \$key => \$anlink):
                ?>
EOF;

        $parse .= $content;
        $parse .= '<?php endforeach; ?>';
        return $parse;
    }

    /**
     * 获取banner列表
     */
    public function tagBanner($tag,$content){
        $pid = $tag['id'];
        $limit = isset($tag['limit']) ? $tag['limit'] : '';
        $parse = <<<EOF
        <?php
               \$__LIST__ = think\Db::name('banner_detail')->where(['pid'=> $pid]);
               if("$limit" != ''){
                        \$__LIST__=\$__LIST__->limit($limit);
                    }
                \$__LIST__=\$__LIST__->select();

                foreach(\$__LIST__ as \$key => \$banner):
                ?>
EOF;

        $parse .= $content;
        $parse .= '<?php endforeach; ?>';
        return $parse;
    }

}