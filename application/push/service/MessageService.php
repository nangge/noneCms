<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2018/4/3
 * Time: 14:38
 */

namespace app\push\service;


use app\common\model\Chat;
use app\push\controller\WorkerChat;
//use app\push\lib\User;
use app\common\model\User;
use app\common\model\Chatrecord;

class MessageService
{
    public function parseMessage($connect_id, $data)
    {
        switch ($data['type']) {
            case 'login':
                $user = User::login($data['username'], $data['password']);
                if (empty($user)) {
                    $result['back_message'] = [
                        'content' => '账号或密码不正确',
                        'type' => 'login',
                        'code' => 0
                    ];
                } else {
                    WorkerChat::$hasConnections[$connect_id] = [
                        'id' => $connect_id,
                        'user' => [
                            'id' => $user['id'],
                            'username' => $user['username'],
                            'img' => $user['img']
                        ]
                    ];

                    WorkerChat::$hasLogin[$user['accesstoken']]['lastlogin_time'] = time();

                    $result['message'] = [
                        'content' => $user['username'] . '加入了聊天室',
                        'username' => '<b style="color:red">系统：</b>',
                        'type' => 'login',
                        'clients' => WorkerChat::$hasConnections,
                        'client_id' => $connect_id,
                        'img' => '/template/index/blog/images/nango.jpg',
                        'time' => date('Y-m-d H:i'),
                        'code' => 1
                    ];
                    $result['back_message'] = [
                        'content' => '登录成功',
                        'user' => [
                            'id' => $user['id'],
                            'username' => $user['username'],
                            'img' => $user['img']
                        ],
                        'accesstoken' => $user['accesstoken'],
                        'img' => $user['img'],
                        'code' => 2,
                        'type' => 'login',
                        'client_id' => $connect_id,
                    ];
                }
                break;
            case 'register':
                $img = file_get_contents('http://placeimg.com/30/30');
                $data['img'] = 'data:image/jpeg;base64,' . base64_encode($img);
                $res = User::register($data);
                if ($res['code'] == 1) {
                    $user = $res['user'];
                    WorkerChat::$hasConnections[$connect_id] = [
                        'id' => $connect_id,
                        'user' => [
                            'id' => $user['id'],
                            'username' => $user['username'],
                            'img' => $user['img']
                        ]
                    ];

                    WorkerChat::$hasLogin[$user['accesstoken']]['lastlogin_time'] = time();

                    $result['message'] = [
                        'content' => $user['username'] . '加入了聊天室',
                        'username' => '<b style="color:red">系统：</b>',
                        'type' => 'register',
                        'clients' => WorkerChat::$hasConnections,
                        'img' => '/template/index/blog/images/nango.jpg',
                        'client_id' => $connect_id,
                        'time' => date('Y-m-d H:i'),
                        'code' => 1
                    ];
                    $result['back_message'] = [
                        'content' => '注册成功',
                        'user' => [
                            'id' => $user['id'],
                            'username' => $user['username'],
                            'img' => $user['img']
                        ],
                        'img' => $user['img'],
                        'accesstoken' => $user['accesstoken'],
                        'code' => 2,
                        'type' => 'register',
                        'client_id' => $connect_id,
                    ];
                } else {
                    $result['back_message'] = [
                        'content' => $res['message'],
                        'type' => 'register',
                        'code' => 0
                    ];
                }
                break;
            case 'prisay':
                if (!isset(WorkerChat::$hasConnections[$connect_id]['user'])) {
                    $result['message'] = [
                        'content' => '非法操作，请确认已登录',
                        'type' => 'prisay',
                        'code' => 0
                    ];
                } else {
                    $user = WorkerChat::$hasConnections[$connect_id]['user'];
                    $recive_user = isset(WorkerChat::$hasConnections[$data['to_client_id']]['user']) ? WorkerChat::$hasConnections[$data['to_client_id']]['user'] : [];
                    if (empty($recive_user)) {
                        $result['message'] = [
                            'content' => '对方已经退出了房间',
                            'username' => '<b style="color:red">系统：</b>',
                            'type' => 'prisay',
                            'clients' => WorkerChat::$hasConnections,
                            'img' => '/template/index/blog/images/nango.jpg',
                            'time' => date('Y-m-d H:i'),
                            'code' => 1
                        ];
                    } else {
                        $recive_content = '<i style="color:green">' . $user['username'] . '</i>对你 说：' . $data['content'];
                        $send_content = '你对<i style="color:green">' . $recive_user['username'] . '</i> 说：' . $data['content'];
                        $result['message'] = [
                            'content' => $send_content,
                            'username' => $user['username'],
                            'type' => 'prisay',
                            'img' => $user['img'],
                            'time' => date('Y-m-d H:i'),
                            'code' => 1
                        ];
                        $result['send_message'] = [
                            'content' => $recive_content,
                            'username' => $recive_user['username'],
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
                        Chat::create($save_data);
                    }
                }
                break;
            case 'reconnect':
                $user = User::getUserByAccessToken($data['accesstoken']);
                if (empty($user)) {
                    $result['back_message'] = [
                        'content' => '用户账号异常，请重新登录',
                        'type' => 'relogin',
                        'code' => 0
                    ];
                } else {
                    $alter_time = WorkerChat::LOGIN_TIME_ALTER + 1;
                    if (isset(WorkerChat::$hasLogin[$user['accesstoken']])) {
                        $alter_time = time() - WorkerChat::$hasLogin[$user['accesstoken']]['lastlogin_time'];
                    }
                    //$alter_time < WorkerChat::LOGIN_TIME_ALTER
                    if (false) {
                        $result['back_message'] = [
                            'content' => '用户重新登录异常，一分钟内不允许连续登陆',
                            'type' => 'relogin',
                            'code' => 3
                        ];
                    } else {
                        WorkerChat::$hasLogin[$user['accesstoken']]['lastlogin_time'] = time();

                        WorkerChat::$hasConnections[$connect_id] = [
                            'id' => $connect_id,
                            'user' => [
                                'id' => $user['id'],
                                'username' => $user['username'],
                                'img' => $user['img']
                            ]
                        ];
                        $result['message'] = [
                            'content' => $user['username'] . '加入了聊天室',
                            'username' => '<b style="color:red">系统：</b>',
                            'type' => 'login',
                            'clients' => WorkerChat::$hasConnections,
                            'client_id' => $connect_id,
                            'img' => '/template/index/blog/images/nango.jpg',
                            'time' => date('Y-m-d H:i'),
                            'code' => 1
                        ];
                        $result['back_message'] = [
                            'content' => '登录成功',
                            'user' => [
                                'id' => $user['id'],
                                'username' => $user['username'],
                                'img' => $user['img']
                            ],
                            'accesstoken' => $user['accesstoken'],
                            'img' => $user['img'],
                            'code' => 2,
                            'type' => 'login',
                            'client_id' => $connect_id,
                        ];
                    }
                }
                break;
            default:
                $user = WorkerChat::$hasConnections[$connect_id]['user'];
                $result['message'] = [
                    'content' => $data['content'],
                    'username' => $user['username'],
                    'type' => 'say',
                    'time' => date('Y-m-d H:i'),
                    'img' => $user['img']
                ];
                $save_data = [
                    'user_id' => $user['id'],
                    'content' => $data['content'],
                    'type' => 0,
                ];
                Chat::create($save_data);
                break;
        }
        return $result;
    }
}