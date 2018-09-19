<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2018/3/29
 * Time: 14:09
 */

namespace app\push\controller;

use app\common\model\Chat;
use app\push\lib\User;
use app\push\service\MessageService;
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

    const LOGIN_TIME_ALTER = 20;//登录时间间隔


    /**
     * 图灵机器人api
     **/
    private $tlApi = 'http://www.tuling123.com/openapi/api';

    /**
     * 图灵 appkey
     * @var string
     */
    private $tlAppkey = 'bbfc225d841dacd734918f77679d5053';

    public static $hasConnections = [];

    public static $hasLogin = [];

    const HEART_ALERT = 300;


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
        $message_service = new MessageService();
        $result = $message_service->parseMessage($connect_id,$data);
        if ($data['type'] == 'login' || $data['type'] == 'register' || $data['type'] == 'reconnect') {
            if ($result['back_message']['code'] == 2) {
                $this->sendMessageToOne($connect_id, $result['back_message']);
                $this->sendMessageToAll($result['message']);
            } else{
                $this->sendMessageToOne($connect_id, $result['back_message']);
            }
        } else {
            if ($data['to_client_id'] == 'all') {
                $this->sendMessageToAll($result['message']);
                $user = self::$hasConnections[$connect_id]['user'];
                $this->sendMessageToTuling($user,$data['content']);
            } else {
                $this->sendMessageToOne($data['client_id'], $result['message']);
                $this->sendMessageToOne($data['to_client_id'], $result['send_message']);
            }
        }
    }


    /**
     * 图灵回复
     * @param content string
     * @return string
     **/
    public function sendMessageToTuling($user,$text){
        $data = array(
            'key' => $this->tlAppkey,
            'info' => $text,
            'userid' => $user['id']
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

        $message = [
            'content' => $res_text,
            'username' => '图灵机器人',
            'type' => 'say',
            'time' => date('Y-m-d H:i'),
            'img' => "http://file.tuling123.com/static/2017-07-24-icon40.png"
        ];

        $save_data = [
            'user_id' => 0,
            'content' => $res_text,
            'type' => 0,
        ];

        if (Chat::create($save_data)) {
            $this->sendMessageToAll($message);
            return true;
        } else {
            return false;
        }
    }


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
                'content' => $user['username'] . '悄悄的走了',
                'username' => '<b style="color:red">系统：</b>',
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