<?php
namespace app\admin\controller;
use app\common\controller\Common;


class Login extends Common
{
	/**
	* @param username string 账号
	* @param password string 密码
	*/
	public function login()
  	{
		$username = input('username');
		$password = input('password');
		self::verify(['username'=>$username,'password'=>$password],'login');

		$admin = db('admin')->field('id, nickname, auth, status')->where(['username'=>$username,'password'=>md5($password)])->find();
		if(empty($admin)){
			return json(['code'=>1,'message'=>'账号密码错误']);
		}else{
		    if($admin['status'] == '2'){
                return json(['code'=>1,'message'=>'该账号已被冻结']);
            }
			$id = $admin['id'];
			$nickname = $admin['nickname'];
			$token = self::get_token($id);

			db('admin')->where(['id'=>$id])->update(['token'=>$token]);

			return json(['code'=>0, 'data'=>['token'=>$token, 'nickname'=>$nickname, 'auth'=>$admin['auth']]]);
		}
  	}
}
