<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2018/4/3
 * Time: 13:51
 */

namespace app\index\controller;

use app\common\model\Chatroom;

class Room
{
    public function getList(){
        $room = Chatroom::all(['status'=>1])->hidden(['status','type']);
        return json($room);
    }
}