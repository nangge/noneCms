<?php
/**
 * 多说评论系统专用类
 */
namespace app\admin\controller;

use think\Db;
use think\facade\Request;
use app\common\model\Comment as commentModel;
use think\Validate;

class Comment extends Common
{
	/**
	** 多说密钥
	**/
	private $secet = "db2243ff09335bfad3da6fe7f37f98e6";

	/**
	** 多说站点名称
	**/
	private $name = "nango";


    public function index()
    {
        $list = commentModel::where(['status' => 0])->order('id DESC')->paginate(20);
        $this->assign('page',$list->render());
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * 添加/回复留言
     */
    public function add(){
        if (request()->isPost()) {
            //新增处理
            $params = input('post.');
            $comment = new commentModel();
            $validate = new Validate([
                'title'=>'require|token',
                'content'=>'require'
            ]);
            if(!$validate->check($params)){
                return ['status' => 0, 'msg' => '添加失败,'.$validate->getError(), 'url' => ''];
            }
            if ($comment->data($params,true)->save()) {
                return ['status' => 1, 'msg' => '添加成功', 'url' => url('comment/index')];
            }else{
                return ['status' => 0, 'msg' => '添加失败', 'url' => ''];
            }
        }else{

            $id = input('param.id/d',0);
            $this->assign('item',commentModel::get($id));
            return $this->fetch();
        }
    }

    /**
     * 删除留言
     * @return [type] [description]
     */
    public function dele() {
        $id = input('param.id/d',0);

        $comment = new commentModel();
        //逻辑删除
        if ($comment->save(['status' => 1],['id' => $id])) {
            return ['status' => 1, 'msg' => '删除成功'];
        }else{
            return ['status' => 0, 'msg' => '删除失败'];
        }
    }

    /**
    * 反向同步多说评论
    *
    **/
    public function syncComment(){
    	echo 1;
    }

    function sync_log() {
        if ($this->check_signature($_POST)) {

            $limit = 20;

            $params = array(
                'limit' => $limit,
                'order' => 'asc',
            );


            $posts = array();

            if (!$last_log_id)
                $last_log_id = 0;

            $params['since_id'] = $last_log_id;
            $response = $http_client->request('GET', 'http://api.duoshuo.com/log/list.json', $params);

            if (!isset($response['response'])) {
                //处理错误,错误消息$response['message'], $response['code']
                //...

            } else {
                //遍历返回的response，你可以根据action决定对这条评论的处理方式。
                foreach($response['response'] as $log){

                    switch($log['action']){
                        case 'create':
                            //这条评论是刚创建的
                            break;
                        case 'approve':
                            //这条评论是通过的评论
                            break;
                        case 'spam':
                            //这条评论是标记垃圾的评论
                            break;
                        case 'delete':
                            //这条评论是删除的评论
                            break;
                        case 'delete-forever':
                            //彻底删除的评论
                            break;
                        default:
                            break;
                    }

                    //更新last_log_id，记得维护last_log_id。（如update你的数据库）
                    if (strlen($log['log_id']) > strlen($last_log_id) || strcmp($log['log_id'], $last_log_id) > 0) {
                        $last_log_id = $log['log_id'];
                    }

                }


            }


        }
    }

    /**
     *
     * 检查签名
     *
     */
    function check_signature($input){

        $signature = $input['signature'];
        unset($input['signature']);

        ksort($input);
        $baseString = http_build_query($input, null, '&');
        $expectSignature = base64_encode(hmacsha1($baseString, $secret));
        if ($signature !== $expectSignature) {
            return false;
        }
        return true;
    }

    // from: http://www.php.net/manual/en/function.sha1.php#39492
    // Calculate HMAC-SHA1 according to RFC2104
    // http://www.ietf.org/rfc/rfc2104.txt
    function hmacsha1($data, $key) {
        if (function_exists('hash_hmac'))
            return hash_hmac('sha1', $data, $key, true);

        $blocksize=64;
        if (strlen($key)>$blocksize)
            $key=pack('H*', sha1($key));
        $key=str_pad($key,$blocksize,chr(0x00));
        $ipad=str_repeat(chr(0x36),$blocksize);
        $opad=str_repeat(chr(0x5c),$blocksize);
        $hmac = pack(
                'H*',sha1(
                        ($key^$opad).pack(
                                'H*',sha1(
                                        ($key^$ipad).$data
                                )
                        )
                )
        );
        return $hmac;
    }

    /**
     * 发起GET请求
     *
     * @access protected
     * @param string $url
     * @return string
     */
    protected function get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

}
