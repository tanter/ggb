<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/8
 * Time: 10:48
 */
namespace app\common\email;

class SendEmail
{
    /*public static  $Host = 'smtp.qq.com';            //smtp服务器 必填
    private static $From = '1583819209@qq.com';      //发送者的邮件地址 必填
    private static $FromName = '三余无梦生';         //发送邮件的用户昵称 非必填
    private static $Username = '1583819209@qq.com';  //登录到邮箱的用户名 必填
    private static $Password = 'hqsbpxyqzzndgiia';  //第三方登录的授权码，在邮箱里面设置 必填
*/
    public static  $Host = 'smtp.163.com';            //smtp服务器 必填
    private static $From = 'blessint@163.com';      //发送者的邮件地址 必填
    private static $FromName = '';         //发送邮件的用户昵称 非必填
    private static $Username = 'blessint@163.com';  //登录到邮箱的用户名 必填
    private static $Password = 'blessint123';  //第三方登录的授权码，在邮箱里面设置 必填
    
    public function __construct()
    {
         $p = db('params')->field('email_host,email_from,email_fromname,email_username,email_password')->where('id=1')->find();
         self::$Host = $p['email_host'];
         self::$From = $p['email_from'];
         self::$FromName = $p['email_fromname'];
         self::$Username = $p['email_username'];
         self::$Password = $p['email_password'];
    }

    /**
     * @desc 发送普通邮件
     * @param $title 邮件标题
     * @param $message 邮件正文
     * @param $emailAddress 邮件地址
     * @return bool|string 返回是否发送成功
     */
    public function SendEmail($title=1,$message=1,$emailAddress='')
    {
        $mail = new PHPMailer();
        //3.设置属性，告诉我们的服务器，谁跟谁发送邮件
        $mail -> IsSMTP();            //告诉服务器使用smtp协议发送
        $mail -> SMTPAuth = true;        //开启SMTP授权
        $mail -> Host = self::$Host;    //告诉我们的服务器使用163的smtp服务器发送
        $mail -> From = self::$From;    //发送者的邮件地址
        $mail -> FromName = self::$FromName;        //发送邮件的用户昵称
        $mail -> Username = self::$Username;    //登录到邮箱的用户名
        $mail -> Password = self::$Password;        //第三方登录的授权码，在邮箱里面设置
        //编辑发送的邮件内容
        $mail -> IsHTML(true);            //发送的内容使用html编写
        $mail -> CharSet = 'utf-8';        //设置发送内容的编码
        $mail -> Subject = $title;//设置邮件的标题
        $mail -> MsgHTML($message);    //发送的邮件内容主体
      
     	$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;
      
        if(is_array($emailAddress)){
            foreach ($emailAddress as $i){
                $mail -> AddAddress($i);//收人的邮件地址多个
            }
        }else{
            $mail -> AddAddress($emailAddress);//收人的邮件地址
        }
		//dump( $mail -> Password);exit;
        //调用send方法，执行发送
      	
        $result = $mail -> Send();
      	
        if($result){
            return true;
        }else{
          	// dump($mail -> ErrorInfo);
            return $mail -> ErrorInfo;
        }
    }
}