<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2018/3/29
 * Time: 14:47
 */

namespace app\common\model;


use think\Validate;
use think\Model;

class User extends Model
{
    protected $autoWriteTimestamp = true;

    public static $hiddenData = ['password'];

    //用户登录
    public static function login($username, $password)
    {
        $user = self::get(['username' => $username, 'password' => md5($password)]);
        if (!$user) {
            return [];
        } else {
            $user->accesstoken = md5(time() . $user['username']);
            $user->accesstoken_expire = time() + 3600 * 2;
            $user->save();
            return $user->hidden(self::$hiddenData);
        }
    }

    //用户注册
    public static function register($data)
    {
        $validate = new Validate([
            'username' => 'require|min:6|max:20',
            'confirm_password'=>'require|min:6|max:20',
            'password' => 'require|min:6|max:20|confirm:confirm_password',
        ]);
        unset($data['type']);
        if (!$validate->check($data)) {
            return [
                'code' => 0,
                'message' => $validate->getError()
            ];
        } else {
            if (self::get(['username' => $data['username']])) {
                return [
                    'code' => 0,
                    'message' => '用户已存在'
                ];
            }
            $data['password'] = md5($data['password']);
            $data['accesstoken'] = md5(time() . $data['username']);
            $data['accesstoken_expire'] = time() + 3600 * 2;
            if ($user = self::create($data)) {
                return [
                    'code' => 1,
                    'message' => '注册成功',
                    'user' => $user->hidden(self::$hiddenData)
                ];
            } else {
                return [
                    'code' => 0,
                    'message' => '注册失败'
                ];
            }
        }
    }

    public static function getUserByAccessToken($accesstoken)
    {
        $user = self::get(['accesstoken' => $accesstoken]);
        if ($user && $user['accesstoken_expire'] > time()) {
            return $user->hidden(self::$hiddenData);
        } else {
            return [];
        }
    }

}