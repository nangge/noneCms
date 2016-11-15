<?php
namespace app\index\controller;

use think\Config;
use think\Db;
use think\View;

class Index extends Common
{
    public function index()
    {

        $this->assign('demo_time',$this->request->time());
        $template = 'template/'. $this->theme .'/Index_index.html';
        return $this->fetch($template);
    }

    public function hello(){
        /*$prev_year = strtotime('-1 year');
        $pyear = date('Y',$prev_year);
        $cyear = date('Y',time());

        echo $pyear.'--'.$cyear;*/

         $login_list = Db::name('log')->whereOr('content',['like','%首页'],['like','index%'])->fetchSql(true)->select();
         print_r($login_list);
       
        //print_r(url('index/index',['id' => 2]));
    }

    public function chat(){
        return $this->fetch();
    }

    /**
    ** 推送用户消息到workerman
    **/
    public function push(){
        $content = input('post.');
        //$content = $message;

        // 建立socket连接到内部推送端口
        $client = stream_socket_client('tcp://127.0.0.1:5678', $errno, $errmsg, 1,  STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT);

        // 发送数据，注意5678端口是Text协议的端口，Text协议需要在数据末尾加上换行符
        fwrite($client, json_encode($content)."\n");
        // 读取推送结果
        $res = fread($client, 8192);

        //内容写入数据库
        $content['send_time'] = time();
        $content['room_id'] = 1;//暂无多房间
        $content['ip'] = request()->ip();
        Db::name('chat')->insert($content);

        echo $res;
    }

    /**
    ** 异步获取聊天记录
    **/
    public function getMessageHis(){
        $list = Db::name('chat')->field("name,content,FROM_UNIXTIME(send_time,'%Y-%m-%d %H:%i') as send_date")->order('send_time DESC')->limit(10)->select();
        exit(json_encode($list));
    }

}
