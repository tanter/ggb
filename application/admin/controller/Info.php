<?php
namespace app\admin\controller;
use app\common\controller\Auth;

class Info extends Auth
{
	// 获取信息
	public function info(){
		$token = input('token');
		$admin = db('admin')->field('nickname, username')->where(['token'=>$token])->find();
		return self::json(0, $admin);
	}
	//退出
	public function logout()
	{
		return self::json(0);
	}

	// 新增账号密码
	public function add()
	{
		$nickname = input('nickname');
		$username = input('username');
		$password = input('password');
		$data = ['username'=>$username,'password'=>$password,'nickname'=>$nickname];
		self::verify($data,'add');

		if(db('admin')->where(['username'=>$username])->count() > 0){
			return self::json(1, null, '该账号已存在');
		}

		$data['password'] = md5($data['password']);
		if(db('admin')->insert($data)){
			return self::json(0, null, '添加成功');
		}else{
			return self::json(1, null, '添加失败');
		}
	}
	// 修改昵称、账号、密码
	public function save()
	{
		$nickname = input('nickname');
		$username = input('username');
		$password = input('password');
		if ($password==='******') $password = '';

		$token 	= input('token');
		if(empty($password)){
			$data = ['username'=>$username,'nickname'=>$nickname];
			self::verify($data,'add2');
		}else{
			$data = ['username'=>$username,'password'=>$password,'nickname'=>$nickname];
			self::verify($data,'add1');
		}

		if(db('admin')->where(['username'=>$username])->count() > 1){
			return self::json(1, null, '该账号已存在');
		}
		if(empty($password)){
			unset($data['password']);
		}else{
			$data['password'] = md5($data['password']);
		}
		
		db('admin')->where(['token'=>$token])->update($data);
		return self::json(0, null, '保存成功');
	}
}
