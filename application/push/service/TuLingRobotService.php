<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2018/11/21
 * Time: 上午9:37
 */

namespace app\push\service;

/**
 * Class TuLingRobotService
 *
 * @package app\push\service 图灵机器人
 */
class TuLingRobotService
{

    /**
     * 错误码
     *
     * @var array
     */
    private static $errorEnum = [
        0 => '上传成功',
        5000 =>	'无解析结果',
        6000 =>	'暂不支持该功能',
        4000 =>	'请求参数格式错误',
        4001 =>	'加密方式错误',
        4002 =>	'无功能权限',
        4003 =>	'该apikey没有可用请求次数',
        4005 =>	'无功能权限',
        4007 =>	'apikey不合法',
        4100 =>	'userid获取失败',
        4200 =>	'上传格式错误',
        4300 =>	'批量操作超过限制',
        4400 =>	'没有上传合法userid',
        4500 =>	'userid申请个数超过限制',
        4600 =>	'输入内容为空',
        4602 =>	'输入文本内容超长(上限150)',
        7002 =>	'上传信息失败',
        8008 => '服务器错误',
    ];

    /**
     * 图灵机器人api
     **/
    private static $tlApi = 'http://openapi.tuling123.com/openapi/api/v2';

    /**
     * 图灵 appkey
     * @var string
     */
    public static $tlAppkey = '53b39db0a7be46029330ab6be51d483e';


    /**
     * 处理消息
     *
     * @param string $data
     *
     * @return bool|string
     */
    public static function handleMessage(string $data)
    {
        $res = post(self::$tlApi, $data, '', 1);
        if (\is_string($res)) {
            $result = \json_decode($res, true);
            if (false === $result) {
                return false;
            }
            if (is_array($result) && $result['intent']['code'] > 10000) {
                if ($result['results']['0']) {
                    $resData = $result['results'][0];
                    if ($resData['resultType'] == 'text') {
                        $return = $resData['values']['text'];
                    } elseif ($resData['resultType'] == 'url') {
                        $return = $resData['values']['url'];
                    } else {
                        return false;
                    }
                    return $return;
                }
            }
        }
        return false;
    }
}
