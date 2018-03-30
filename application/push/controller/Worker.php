<?php
namespace app\push\controller;

use app\common\model\Chat;
use think\facade\Log;
use think\worker\Server;

class Worker extends Server
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

    /**
     * 已连接客户端信息
     * @var array
     */
    protected static $hasConnections = [];

    /**
     * 收到消息
     * @param $connection
     * @param $data
     */
    public function onMessage($connection, $data)
    {
        $data = json_decode($data, true);
        //通信成功
        $connect_id = $connection->id;
        self::$hasConnections[$connect_id] = ['name' => $data['name'], 'id' => $connect_id];
        $this->sendMessage4Type($data, $connection);
    }

    /**
     * 当连接建立时触发的回调函数
     * @param $connection
     */
    public function onConnect($connection)
    {
        echo 'connect';
    }

    /**
     * 当连接断开时触发的回调函数
     * @param $connection
     */
    public function onClose($connection)
    {
        $id = $connection->id;

        $name = self::$hasConnections[$id]['name'];
        unset(self::$hasConnections[$id]);
        $message = [
            'content' => $name . '悄悄的走了',
            'nick' => '<b style="color:red">系统：</b>',
            'type' => 'logout',
            'clients' => self::$hasConnections,
            'time' => date('Y-m-d H:i')
        ];
        $connection->close();
        $this->sendMessageToAll($message);
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
        echo 'WorkerStart';
    }

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

    /**
     ** 根据type推送消息
     ** $data 消息体
     **/
    public function sendMessage4Type($data, $connection = '')
    {
        switch ($data['type']) {
            case 'login':
                $imgfile = file_get_contents($data['img']);
                $img = "data:image/jpeg;base64,".base64_encode($imgfile);
                self::$hasConnections[$connection->id] = [
                    'name' => $data['name'],
                    'id' => $connection->id,
                    'img' => $img
                ];
                $data['img'] = $img;
                $content = '欢迎 <i>' . $data['name'] . '</i> 加入聊天室！    ';
                //生成用户图片并base64编码保存

                //拼装返回的数据结构
                $back_data = [
                    'content' => $content,
                    'nick' => '<b style="color:red">系统：</b>',
                    'client_id' => $connection->id,
                    'client_name' => $data['name'],
                    'type' => 'login',
                    'clients' => self::$hasConnections,
                    'img'=>self::$hasConnections[$connection->id]['img'],
                    'time' => date('Y-m-d H:i'),
                ];
                break;
            case 'prisay':
                $data['img'] = self::$hasConnections[$connection->id]['img'];
                $recive_user = self::$hasConnections[$data['to_client_id']]['name'];//接收者
                $send_user = $data['name'];//发送者
                $recive_content = '<i style="color:green">' . $send_user . '</i>对你 说：' . $data['content'];
                $send_content = '你对<i style="color:green">' . $recive_user . '</i> 说：' . $data['content'];
                //拼装返回的数据结构
                $back_data = [
                    'content' => $recive_content,
                    'type' => 'say',
                    'nick' => $recive_user,
                    'time' => date('Y-m-d H:i'),
                    'img' => $data['img']
                ];
                $mycontent = [
                    'content' => $send_content,
                    'type' => 'say',
                    'nick' => $send_user,
                    'time' => date('Y-m-d H:i'),
                    'img' => $data['img']
                ];
                //写入
                self::insert_chat($data);
                break;
            default:
                //拼装返回的数据结构
                $data['img'] = self::$hasConnections[$connection->id]['img'];
                $back_data = [
                    'content' => $data['content'],
                    'nick' => $data['name'],
                    'type' => 'say',
                    'time' => date('Y-m-d H:i'),
                    'img' => $data['img']
                ];
                //写入
                self::insert_chat($data);
                break;
        }
        $mycontent = isset($mycontent) ? $mycontent : '';
        //判断是否是私聊
        if ($data['to_client_id'] == 'all') {
            $this->sendMessageToAll($back_data);
            if ($data['type'] == 'say') {
                $this->sendMessageToTuling($data['content']); //群聊时图灵 登陆登出除外
                if (false !== strpos($data['content'],'@nango')) {
                    $email = get_system_value('site_email');
                    $message = [
                       'to' => [
                           'email' => $email
                       ],
                        'content' => [
                            'subject' => '聊天室邮件',
                            'body' => $data['content']
                        ]
                    ];
                    if (sendEmail($message)) {
                        $mail_data = [
                            'content' => '邮件已发送',
                            'nick' => '<b style="color:red">系统：</b>',
                            'client_id' => $connection->id,
                            'client_name' => $data['name'],
                            'type' => 'login',
                            'clients' => self::$hasConnections,
                            'time' => date('Y-m-d H:i')
                        ];
                        $this->sendMessageToOne($data['client_id'], $mail_data);
                    }
                }
            }
        } else {
            $this->sendMessageToOne($data['client_id'], $mycontent);
            $this->sendMessageToOne($data['to_client_id'], $back_data);
        }


    }

    /**
     * 聊天数据写入数据表
     * @param $data
     * @return bool
     */
    static function insert_chat($data) {
        $data['send_time'] = time();
        $data['room_id'] = 1;//暂无多房间
        $data['ip'] = request()->ip();
        $chat = new Chat();

        if ($chat->data($data,true)->save()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 图灵回复
     * @param content string
     * @return string
     **/
    public function sendMessageToTuling($text){
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
            'nick' => 'nango的机器人',
            'to_client_id' => 'all',
            'client_id' => '110',
            'time' => date('Y-m-d H:i')
        );

        //内容写入数据库
        $content['send_time'] = time();
        $content['room_id'] = 1;//暂无多房间
        $content['ip'] = request()->ip();
        $chat = new Chat();

        if ($chat->data($content,true)->save()) {
            $this->sendMessageToAll($content);
            return true;
        } else {
            return false;
        }
    }
}
?>