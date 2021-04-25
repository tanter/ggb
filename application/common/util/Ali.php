<?php


namespace app\common\util;


use think\Exception;

class Ali
{

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getCode($redirect_uri)
    {
//        https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id=APPID&scope=SCOPE&redirect_uri=ENCODED_URL
        $appid = $this->config['appid'];
        $url = "https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id={$appid}&scope=auth_user&redirect_uri={$redirect_uri}";
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