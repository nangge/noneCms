<?php
namespace app\index\controller;

use think\facade\Config;
use think\Db;
use think\View;

class Index extends Common
{

    /**
    * toLingUrl 图灵机器人api
    **/
    private $tlApi = 'http://www.tuling123.com/openapi/api';
    private $tlAppkey = '820176b52352471a943d73a8c304ad32';

    public function index()
    {
        $template = 'template/' . request()->module() . '/'. $this->theme .'/Index_index.html';
        return $this->fetch($template);
    }

    /**
     * 聊天室
     * @return [type] [description]
     */
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
        $page = input('param.page');
        $list = Db::name('chat')
                ->field("name,content,FROM_UNIXTIME(send_time,'%Y-%m-%d %H:%i') as send_date")
                ->order('send_time DESC')
                ->limit(($page-1)*10,10)
                ->select();

        exit(json_encode(array_reverse($list)));
    }


    /**
    * 图灵回复
    * @param content string
    * @return string
    **/
    public function sendMessageToTuling(){
        $text = input('param.content');
        $data = array(
            'key' => $this->tlAppkey,
            'info' => $text,
            'userid' => '123456789'
            );
        $res = post($this->tlApi,json_encode($data,JSON_UNESCAPED_UNICODE),'',1);
        $r = json_decode($res,true);
        //文本类
        if(isset($r['url'])){
            //存在链接则发送链接
            $res_text = $r['url'];
        }else{
            $res_text = $r['text'];
        }

        $content = array(
            'type' =>'all',
            'content' => $res_text,
            'name' => 'nango的机器人',
            'to_client_id' => 'all',
            'client_id' => '110'
        );
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
        //echo $r['text'];    
    }

}
