<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2018/3/29
 * Time: 14:34
 */

namespace app\push\lib;

use app\common\model\User as UserModel;
use think\Validate;

class User
{
    //用户登录
    public static function login($username,$password){
        $user = UserModel::get(['username'=>$username,'password'=>md5($password)]);
        if(!$user){
            return [];
        }else{
            return $user->hidden(['password']);
        }
    }
    //用户注册
    public static function register($data){
        $validate = new Validate([
            'username'=>'require|min:6|max:20',
            'password'=>'require|min:6|max:20',
            'nick'=>'require'
        ]);
        unset($data['type']);
        if(!$validate->check($data)){
            return [
                'code'=>0,
                'message'=>$validate->getError()
            ];
        }else{
            if(UserModel::get(['username'=>$data['username']])){
                return [
                    'code'=>2,
                    'message'=>'用户已存在'
                ];
            }
            $data['password'] = md5($data['password']);
            if($user = UserModel::create($data)){
                return [
                    'code'=>1,
                    'message'=>'注册成功',
                    'user'=>$user->hidden(['password'])
                ];
            }else{
                return [
                    'code'=>3,
                    'message'=>'注册失败'
                ];
            }
        }
    }
}