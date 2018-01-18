<?php
/**
 * Created by PhpStorm.
 * User: nango
 * Date: 2018/1/3
 * Time: 17:23
 */

namespace app\common\model;

use think\Model;

class Admin extends Model
{
    protected $pk = 'id';

    /**
     * 新增的时候进行字段的自动完成机制
     * @var array
     */
    protected $insert = ['createtime'];

    /**
     * 更新的时候进行字段的自动完成机制
     * @var array
     */
    protected $update = ['loginip'];

    const ISLOCK_NO = 0;
    const ISLOCK_YES = 3;

    static $lock_desc = [
        self::ISLOCK_NO => '否',
        self::ISLOCK_YES => '是',
    ];

    public function role()
    {
        return $this->belongsTo('AdminRole', 'role_id');
    }

    public function setLoginipAttr()
    {
        return request()->ip();
    }

    public function setCreatetimeAttr()
    {
        return time();
    }


    /**
     * 密码加盐处理
     * @return string
     */
//    public function setPasswordAttr($value, $data)
//    {
//        return get_password($value, $data['encrypt']);
//    }

}