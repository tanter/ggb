<?php


namespace app\common\util;


use think\Exception;

class Wechat
{

    private $basePath = 'https://open.weixin.qq.com/';
    private $config;
    private function getTimeStamp(){
        return strtotime(date('Y-m-d H:i:s', time()));
    }
    public function __construct($config)
    {
        if(!isset($config['state']))$config['state'] = null;
        $this->config = $config;
    }
    public function getTicket(){
        $wx = db('wx')->where('id=1')->find();
        if($wx['ticket_time'] - $this->getTimeStamp() > $wx['ticket_expires']) return $wx['ticket'];

        $access_token = $this->getToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi';
        $res = $this->get_https_data($url);
        $res = json_decode($res, true);
        if($res&&isset($res['ticket'])){
            db('wx')->where('id=1')->update(['ticket_time'=>$this->getTimeStamp(), 'ticket_expires'=>$res['expires_in'], 'ticket'=>$res['ticket']]);
            return $res['ticket'];
        }else{
            return '';
        }
    }
    public function getCode($redirect_uri)
    {
        $path = 'connect/oauth2/authorize';
        $params = [
            'appid' => $this->config['app_id'],
            'redirect_uri' => $redirect_uri,
            'response_type' => 'code',
            'scope' => 'snsapi_userinfo',
            'state'=>$this->config['state']
        ];
        $query = http_build_query($params) . '#wechat_redirect';
        $url = $this->basePath . $path . '?' . $query;
        return $url;
    }

    public function getAccessToken($code)
    {
        $appid = $this->config['app_id'];
        $appsecret = $this->config['secret'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        $res = $this->get_https_data($url);
        if (!$res) {
            throw new Exception('授权失败');
        }
        $resArr = json_decode($res, true);

        if (!isset($resArr['access_token']) || !$resArr['access_token']) {
            throw new Exception('获取access_token失败');
        }
        return $resArr;
    }
    public function getToken(){
        $wx = db('wx')->where('id=1')->find();
        if($wx['token_time'] - $this->getTimeStamp() > $wx['token_expires']) return $wx['token'];

        $appid = $this->config['app_id'];
        $appsecret = $this->config['secret'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        $res = $this->get_https_data($url);
        $res = json_decode($res, true);
        if($res&&isset($res['access_token'])){
            db('wx')->where('id=1')->update(['token_time'=>$this->getTimeStamp(), 'token_expires'=>$res['expires_in'], 'token'=>$res['access_token']]);
            return $res['access_token'];
        }else{
            return '';
        }
    }

    public function auth($code)
    {
        $tokenArr = $this->getAccessToken($code);
        $resArr = $this->getUserInfo($tokenArr['openid'], $tokenArr['access_token']);
        if(!isset($resArr['openid'])|| !$resArr['openid']){
            throw new Exception('获取用户信息失败');
        }
        return $resArr;
    }

    //获取个人信息
    protected function getUserInfo($openid,$access_token)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
        $res = $this->get_https_data($url);
        return json_decode($res, true);
    }
    public function verifyToken($token){
        $nonce     = $_GET['nonce'];
        $timestamp = $_GET['timestamp'];
        $echostr   = $_GET['echostr'];
        $signature = $_GET['signature'];
        //形成数组，然后按字典序排序
        $array = array();
        $array = array($nonce, $timestamp, $token);
        sort($array);
        //拼接成字符串,sha1加密 ，然后与signature进行校验
        $str = sha1( implode( $array ) );
        if( $str == $signature && $echostr ){
            //第一次接入weixin api接口的时候
            echo  $echostr;
            exit;
        }
    }
    /*
* @source curl 模拟浏览器请求数据
* @obj data 返回来的json字符串对象
*/
    private function get_https_data($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }


}