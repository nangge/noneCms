<?php
namespace app\index\controller;

use app\common\model\Category;
use app\common\model\Comment;
use app\common\model\Modeln;
use think\Db;
use think\View;

class Guestbook extends Common
{
    /**
     * 留言本
     * *
    **/
    public function index($cid = 0){
        $cat_info = Category::get($cid);

        $template_list = $cat_info['template_list'];
        if(!$template_list) {
            $model = Modeln::where(['id' => $cat_info['modelid']])->value('template_list');
            $template_list = $model['template_list'];
        }
        $template = 'template/index/'. $this->theme .'/'.$template_list;
        $this->assign('cate',$cat_info);
        $this->assign('title',empty($cat_info['seotitle'])?$cat_info['name']:$cat_info['seotitle']);
        $this->assign('keywords',$cat_info['keywords']);
        $this->assign('description',$cat_info['description']);
        $this->assign('cid',$cid);
        return $this->fetch($template);
        $list = Comment::where('status',0)->paginate(15);
        $this->assign([
            'list' => $list,
            'page' => $list->render()
            ]);
        return $this->fetch();
    }

    /**
     * 留言
     */
    public function add(){
        $data = input('param.');

        if ($data['title'] == ''){
            $this->error('请填写标题');
        }

        if ($data['username'] == ''){
            $this->error('请填写姓名');
        }

        if ($data['content'] == ''){
            $this->error('请填写留言内容');
        }

        $params = input('post.');
        $comment = new Comment();

        if($comment->data($params,true)->save()){
            $this->success('留言成功');
        }else{
            $this->error('留言失败，请稍后重试');
        }

    }

}
