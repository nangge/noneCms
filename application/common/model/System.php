<?php
/**
 * Created by PhpStorm.
 * User: nango
 * Date: 2018/1/5
 * Time: 12:59
 */
namespace app\common\model;

use think\Model;

class System extends Model {
    protected $pk = 'id';
    public static function getConfigByType($type)
    {
       $systems = self::all();
        $res = [];
        foreach($systems as $value){
            list($key,$item) = explode('_',$value['name']);
            if($key == $type){
                $res[$item] = $value['value'];
            }
        }
        return $res;
    }
}