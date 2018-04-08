<?php
/**
 * Created by PhpStorm.
 * User: zhl
 * Date: 2018/3/27
 * Time: 9:27
 */

namespace app\common\lib\email;
use app\common\lib\exception\EmailException;
use PHPMailer\PHPMailer\PHPMailer;
use think\Exception;

class Email
{

    protected $config = [
        'debug'=>0,
        'auth'=>true,
        'secure'=>'tls',
        'charset'=>'UTF-8'
    ];

    protected $mail;

    protected $content;

    public function __construct($config)
    {
        $this->config = array_merge($this->config,$config);
    }

    public function __get($name)
    {
        return $this->config[$name];
    }

    public function __set($name, $value)
    {
        if (isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    public function create($content){
        $this->mail = new PHPMailer(true);
        $this->mail->CharSet=$this->charset;// Passing `true` enables exceptions
            //Server settings
        $this->mail->SMTPDebug = $this->debug;                                 // Enable verbose debug output
        $this->mail->isSMTP();                                      // Set mailer to use SMTP
        $this->mail->Host = $this->host;  // Specify main and backup SMTP servers
        $this->mail->SMTPAuth = $this->auth;                               // Enable SMTP authentication
        $this->mail->Username = $this->username;                 // SMTP username
        $this->mail->Password = $this->password;                           // SMTP password
        $this->mail->SMTPSecure = $this->secure;                            // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port = $this->port;                                    // TCP port to connect to
        $this->content = $content;
        return $this;
    }
    public function setRecipient(){
        $recipient = $this->content;
        if($this->fromemail&&$this->fromuser){
            $this->mail->setFrom($this->fromemail,$this->fromuser);
        }else{
            throw new EmailException(['msg'=>'必须填写发件人邮箱地址和发件人']);
        }
        if(isset($recipient['to']['email'])&&isset($recipient['to']['username'])){
            $this->mail->addAddress($recipient['to']['email'], $recipient['to']['email']);     // Add a recipient
        }elseif(isset($recipient['to']['email'])){
            $this->mail->addAddress($recipient['to']['email']);
        }elseif(isset($recipient['replyto']['email'])&&isset($recipient['replyto']['username'])){
            $this->mail->addReplyTo($recipient['replyto']['email'], $recipient['replyto']['email']);     // Add a recipient
        }elseif(isset($recipient['replyto']['email'])){
            $this->mail->addReplyTo($recipient['replyto']['email']);
        }else{
            throw new Exception('必须填写收件人邮箱地址');
        }

        if(isset($recipient['cc']['email'])){
            $this->mail->addCC($recipient['cc']['email']);
        }

        if(isset($recipient['bcc']['email'])){
            $this->mail->addBCC($recipient['bcc']['email']);
        }
        return $this;
    }

    public function attachment(){
        if(isset($this->content['attachment'])){
            $attachments = $this->content['attachment'];
            //Attachments
            if(!is_array($attachments)||empty($attachments)){

            }else{
                $this->mail->addAttachment($attachments['path']);
            }
        }
        return $this;
    }

    public function body($ishtml = true){
        $content = $this->content['content'];
        if($ishtml){
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = $content['subject'];
            $this->mail->Body    = $content['body'];
        }else{
            $this->mail->AltBody = $content['body'];
        }
        return $this;
    }

    public function send(){
        if($this->mail->send()){
            return true;
        }else{
            throw new EmailException(['msg'=>'邮件发送失败']);
        }
    }
}