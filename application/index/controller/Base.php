<?php
namespace app\index\controller;
use app\common\controller\Common;
use app\common\email\SendEmail;

use think\facade\Session;

class Base extends Common
{
	public function __construct()
	{
		parent::__construct();
	}
	public static function get_code(){
		return rand(10000,99999);
	}
    // 发送手机短信验证码
    public function sendTelSms($tel, $code)
    {
    	return self::send_sms($tel, $code);
    }
    // 发送邮箱验证码
    public function sendEmailSms($address, $code){
  		$email = new SendEmail();
  		return $email->SendEmail('BLEX', '您的验证码为: '.$code, $address);
    }
    public static function get_uid()
    {
        $token = input('token');
        $uid = db('user')->where(['token'=>$token])->value('id');
        if(empty($token) || empty($uid)){
            echo json_encode(['code'=>1000, 'message'=>'TOKEN验证错误，2秒后跳转登陆界面', 'time' => 2]);
            exit;
        }
        return $uid;
    }
    // 获取用户某个字段值
    public static function get_user_felid_value($uid,$key)
    {
        return db('user')->where(['id'=>$uid])->value($key);
    }

    private function set_session_cache($id, $expire, $key, $value)
    {
        $index = strstr($id,'@');
        if($index){
            $id = explode('@',$id)[0];
        }
    	Session::init([
            'auto_start' => true,
            'id' => $id,
            'expire' => $expire
        ]);
        Session::set($key, $value);
    }
    private function get_session_cache($id, $key)
    {
        $index = strstr($id,'@');
        if($index){
            $id = explode('@',$id)[0];
        }
    	Session::init([
            'auto_start' => true,
            'id' => $id,
        ]);
        return Session::get($key);
    }
    // 设置验证码缓存
    protected function setCodeCache($account, $code)
    {
    	$this->set_session_cache($account, 10, 'web_code', $code);
    }
    // 获取验证码缓存
    protected function getCodeCache($account)
    {
    	return $this->get_session_cache($account, 'web_code');
    }



    // 返回用户信息
    protected function get_user_info($condition)
    {
        $user = db('user')->where($condition)->find();
        // $idcard = db('user_id_card')->where(['user_id'=>$user['id'], 'is_delete'=>0])->order('id desc')->find();
        return [
            'name'=>$user['name'],
            'token'=>$user['token'], 
            'invitation_code'=>$user['invitation_code'], 
            'phone'=>$user['phone'], 
            'email'=>$user['email'], 
            'transaction_password'=>empty($user['transaction_password']) ? 0 : 1,
            'id_card'=>$user['id_card'],
            'bank_name'=>$user['bank_name'],
            'bank_number'=>$user['bank_number'],
            'alipay_account'=>$user['alipay_account'],
            'weixin_nickname'=>$user['weixin_nickname'],
            'weixin_account'=>$user['weixin_account'],
        ];
    }
    // 保存交易日志
    public static function s_w_l($uid, $gl_id, $money, $msg, $type, $ramark='')
    {
        return db('user_wallet_log')->insertGetId([
                'user_id' => $uid,
                'gl_id' => $gl_id,
                'money' => $money,
                'message' => $msg,
                'add_time' => self::getDate(),
                'type' => $type,
                'ramark' => $ramark
            ]);
    }

    // 获取市价的价格
    protected function get_currency_jy_value($currency, $type, $index, $value = 'deal')
    {
        $jy = db('currency_jy')->where(['currency' => $currency, 'type' => $type])->limit(0,1)->value($value);
        if(empty($jy)){
            echo json_encode(['code'=>1, 'message'=>'获取价格失败']);
            exit;
        }
        // value  // 交易对、币种、当前价格、人民币价格、最高价、最低价、涨幅、24小时成交量
        // deal   // 交易对 (数量，价格)卖10 + (数量，价格)买10
        $arr = explode(',', $jy);
        return $arr[$index];
    }
}
