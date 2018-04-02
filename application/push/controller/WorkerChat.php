<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2018/3/29
 * Time: 14:09
 */

namespace app\push\controller;

use app\common\model\Chatrecord;
use app\push\lib\User;
use think\worker\Server;
use Workerman\Lib\Timer;

class WorkerChat extends Server
{
    /**
     * 进程数
     * @var int
     */
    protected $processes = 1;

    protected $socket = 'websocket://0.0.0.0:2345';

    /**
     * 图灵机器人api
     **/
    private $tlApi = 'http://www.tuling123.com/openapi/api';

    /**
     * 图灵 appkey
     * @var string
     */
    private $tlAppkey = 'bbfc225d841dacd734918f77679d5053';

    protected static $hasConnections = [];


    const HEART_ALERT = 30;


    //向所有在线用户推送消息
    public function sendMessageToAll($message)
    {
        foreach ($this->worker->connections as $connection) {
            $connection->send(json_encode($message));
        }

    }

    /**
     ** 向指定用户推送消息
     ** $cid $connection->id
     ** $message 消息
     **/
    public function sendMessageToOne($cid, $message)
    {
        $this->worker->connections[$cid]->send(json_encode($message));
    }


    public function onMessage($connection, $data)
    {
        $data = json_decode($data, true);

        $connection->lastsendtime = time();

        $this->sendMessageByType($connection, $data);

    }

    public function sendMessageByType($connection, $data)
    {
        $connect_id = $connection->id;
        switch ($data['type']) {
            case 'login':
                $user = User::login($data['username'], $data['password']);
                if (empty($user)) {
                    $back_message = [
                        'content' => '账号或密码不正确',
                        'type' => 'login',
                        'code' => 0
                    ];
                } else {
                    self::$hasConnections[$connect_id] = [
                        'id' => $connect_id,
                        'user' => $user
                    ];
                    $message = [
                        'content' => $user['nick'] . '加入了聊天室',
                        'nick' => '<b style="color:red">系统：</b>',
                        'type' => 'login',
                        'clients' => self::$hasConnections,
                        'client_id' => $connect_id,
                        'img' => '/template/index/blog/images/nango.jpg',
                        'time' => date('Y-m-d H:i'),
                        'code' => 1
                    ];
                    $back_message = [
                        'content' => '登录成功',
                        'user' => $user,
                        'img' => $user['img'],
                        'code' => 2,
                        'type' => 'login',
                        'client_id' => $connect_id,
                    ];
                }
                break;
            case 'register':
                $img = file_get_contents('http://lorempixel.com/30/30/');
                $data['img'] = 'data:image/jpeg;base64,'.base64_encode($img);
                $res = User::register($data);
                if ($res['code'] == 1) {
                    $user = $res['user'];
                    self::$hasConnections[$connect_id] = [
                        'id' => $connect_id,
                        'user' => $user
                    ];
                    $message = [
                        'content' => $user['nick'] . '加入了聊天室',
                        'nick' => '<b style="color:red">系统：</b>',
                        'type' => 'register',
                        'clients' => self::$hasConnections,
                        'img' => '/template/index/blog/images/nango.jpg',
                        'client_id' => $connect_id,
                        'time' => date('Y-m-d H:i'),
                        'code' => 1
                    ];
                    $back_message = [
                        'content' => '注册成功',
                        'user' => $user,
                        'img' => $user['img'],
                        'code' => 2,
                        'type' => 'register',
                        'client_id' => $connect_id,
                    ];
                } else {
                    $back_message = [
                        'content' => $res['message'],
                        'type' => 'register',
                        'code' => 0
                    ];
                }
                break;
            case 'prisay':
                if (!isset(self::$hasConnections[$connect_id]['user'])) {
                    $message = [
                        'content' => '非法操作，请确认已登录',
                        'type' => 'prisay',
                        'code' => 0
                    ];
                } else {
                    $user = self::$hasConnections[$connect_id]['user'];
                    $recive_user = isset(self::$hasConnections[$data['to_client_id']]['user']) ? self::$hasConnections[$data['to_client_id']]['user'] : [];
                    if (empty($recive_user)) {
                        $message = [
                            'content' => '对方已经退出了房间',
                            'nick' => '<b style="color:red">系统：</b>',
                            'type' => 'prisay',
                            'clients' => self::$hasConnections,
                            'img' => '/template/index/blog/images/nango.jpg',
                            'time' => date('Y-m-d H:i'),
                            'code' => 1
                        ];
                    } else {
                        $recive_content = '<i style="color:green">' . $user['nick'] . '</i>对你 说：' . $data['content'];
                        $send_content = '你对<i style="color:green">' . $recive_user['nick'] . '</i> 说：' . $data['content'];
                        $message = [
                            'content' => $send_content,
                            'nick' => $user['nick'],
                            'type' => 'prisay',
                            'img' => $user['img'],
                            'time' => date('Y-m-d H:i'),
                            'code' => 1
                        ];
                        $send_message = [
                            'content' => $recive_content,
                            'nick' => $recive_user['nick'],
                            'type' => 'prisay',
                            'img' => $recive_user['img'],
                            'time' => date('Y-m-d H:i'),
                            'code' => 1
                        ];
                        $save_data = [
                            'user_id' => $user['id'],
                            'content' => $data['content'],
                            'type' => 1,
                            'receive_id' => $recive_user['id'],
                        ];
                        Chatrecord::create($save_data);
                    }
                }
                break;
            case 'reconnect':
                $user = \app\common\model\User::get($data['id']);
                if (empty($user)) {
                    $back_message = [
                        'content' => '用户账号异常，请重新登录',
                        'type' => 'relogin',
                        'code' => 0
                    ];
                } else {
                    self::$hasConnections[$connect_id] = [
                        'id' => $connect_id,
                        'user' => $user
                    ];
                    $message = [
                        'content' => $user['nick'] . '加入了聊天室',
                        'nick' => '<b style="color:red">系统：</b>',
                        'type' => 'login',
                        'clients' => self::$hasConnections,
                        'client_id' => $connect_id,
                        'img' => '/template/index/blog/images/nango.jpg',
                        'time' => date('Y-m-d H:i'),
                        'code' => 1
                    ];
                    $back_message = [
                        'content' => '登录成功',
                        'user' => $user,
                        'img' => $user['img'],
                        'code' => 2,
                        'type' => 'login',
                        'client_id' => $connect_id,
                    ];
                }
                break;
            default:
                $user = self::$hasConnections[$connect_id]['user'];
                $message = [
                    'content' => $data['content'],
                    'nick' => $user['nick'],
                    'type' => 'say',
                    'time' => date('Y-m-d H:i'),
                    'img' => $user['img']
                ];
                $save_data = [
                    'user_id' => $user['id'],
                    'content' => $data['content'],
                    'type' => 0,
                ];
                Chatrecord::create($save_data);
                break;
        }
        $send_message = isset($send_message) ? $send_message : '';
        if ($data['type'] == 'login' || $data['type'] == 'register' || $data['type'] == 'reconnect') {
            if ($back_message['code'] == 2) {
                $this->sendMessageToOne($connect_id, $back_message);
                $this->sendMessageToAll($message);
                echo 2;
            } else{
                $this->sendMessageToOne($connect_id, $back_message);
            }
        } else {
            if ($data['to_client_id'] == 'all') {
                $this->sendMessageToAll($message);
            } else {
                $this->sendMessageToOne($data['client_id'], $message);
                $this->sendMessageToOne($data['to_client_id'], $send_message);
            }
        }
    }

//
//    /**
//     * 图灵回复
//     * @param content string
//     * @return string
//     **/
//    public function sendMessageToTuling($text){
//        $data = array(
//            'key' => $this->tlAppkey,
//            'info' => $text,
//            'userid' => '123456789'
//        );
//        $res = post($this->tlApi,json_encode($data,JSON_UNESCAPED_UNICODE),'',1);
//        $r = json_decode($res,true);
//        //文本类
//        if(isset($r['url'])){
//            //存在链接则发送链接
//            $res_text = $r['url'];
//        }else{
//            $res_text = $r['text'];
//        }
//
//        $content = array(
//            'type' =>'all',
//            'content' => $res_text,
//            'nick' => 'nango的机器人',
//            'to_client_id' => 'all',
//            'client_id' => '110',
//            'time' => date('Y-m-d H:i')
//        );
//
//        //内容写入数据库
//        $content['send_time'] = time();
//        $content['room_id'] = 1;//暂无多房间
//        $content['ip'] = request()->ip();
//        $chat = new Chat();
//
//        if ($chat->data($content,true)->save()) {
//            $this->sendMessageToAll($content);
//            return true;
//        } else {
//            return false;
//        }
//    }


    /**
     * 当连接建立时触发的回调函数
     * @param $connection
     */
    public function onConnect($connection)
    {
        echo 'connect' . $connection->id . '\n';
    }

    /**
     * 当连接断开时触发的回调函数
     * @param $connection
     */
    public function onClose($connection)
    {
        $id = $connection->id;

        $user = isset(self::$hasConnections[$id]['user']) ? self::$hasConnections[$id]['user'] : [];
        unset(self::$hasConnections[$id]);
        if ($user) {
            $message = [
                'content' => $user['nick'] . '悄悄的走了',
                'nick' => '<b style="color:red">系统：</b>',
                'type' => 'logout',
                'img' => '/template/index/blog/images/nango.jpg',
                'clients' => self::$hasConnections,
                'time' => date('Y-m-d H:i'),
                'code' => 1
            ];
            $this->sendMessageToAll($message);
        }
        echo 'disconnect' . $connection->id . '\n';
        $connection->close();
    }

    /**
     * 当客户端的连接上发生错误时触发
     * @param $connection
     * @param $code
     * @param $msg
     */
    public function onError($connection, $code, $msg)
    {
        echo "error $code $msg\n";
    }

    /**
     * 每个进程启动
     * @param $worker
     */
    public function onWorkerStart($worker)
    {
        Timer::add(5,function()use($worker){
            $time_now = time();
            foreach($worker->connections as $connection){
                if(empty($connection->lastsendtime)){
                    $connection->lastsendtime = time();
                    continue;
                }

                if($time_now - $connection->lastsendtime > self::HEART_ALERT){
                    echo $connection->id.'disconnect  ';
                    $message = [
                        'type' => 'relogin',
                        'code' => 1
                    ];
                    $this->sendMessageToOne($connection->id, $message);
                    $connection->close();
                }
            }
        });
    }

}