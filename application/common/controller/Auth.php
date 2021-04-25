<?php
namespace app\common\controller;

class Auth extends Common
{
	// 权限验证
	public function __construct()
	{
		parent::__construct();
		$token = input('token');
		if(empty($token)){
			echo json_encode(['code'=>1000, 'message'=>'TOKEN不能为空，2秒后跳转登陆界面', 'time' => 2]);
	    	exit;
		}
		if(!is_numeric(self::get_admin_id($token))){
			echo json_encode(['code'=>1000, 'message'=>'TOKEN验证错误，2秒后跳转登陆界面', 'time' => 2]);
	    	exit;
		}
		$this->getAgentId($token);
	}

	// 获取代理ID并判断是否是代理
	protected function getAgentId($token = null)
	{
		if(empty($token)) $token = input('token');

		$auth = db('admin')->field('auth,id')->where(['token'=>$token])->find();
		if($auth['auth'] === 'agent'){
			$this->checkAuth();
			return intval($auth['id']);
		}
		return false;
	}


	private function checkAuth()
	{
		$path = input('path');
		$evts = $this->request->path();
        if($evts == 'Info/logout') return;

		$events = [
			'User/list' => '/userManage',
			'User/getIdCradList' => '/userAuthentication',
			'User/getWalletList' => '/walletManage',

			'Admin/getList' => '/agentManage',
			'agent/getDealLines' => '/dealDetail',

			'agent/getAssetList' => '/assetManage',

			'agent/getDealLines' => '/dealDetail',

			'agent/getAgentTakeList' => '/takeAudit',  // 获取申请提币列表
			'agent/addAgentTake' => '/takeAudit',
			'agent/calcelAgentTake' => '/takeAudit',
			'User/getCurrency' => '/dashboard',
			'Info/logout' => '/dashboard',
			'agent/home' => '/dashboard',

            'system/getInfo' => ['/changepwd', '/code'],
            'system/save' => '/changepwd',
			'Info/getInfo' => '/',

            'User/getUserOrderList' => ['/userBbOrder', '/userHyOrder'],
            'User/getContractOrderDetail' => ['/userBbOrder', '/userHyOrder'],
            'User/getNowList' => '/userHyfundMonitoring'
		];

		if(!isset($events[$evts]) || ( is_array($events[$evts]) ? !in_array($path , $events[$evts]) : $events[$evts] != $path )){
			echo json_encode(['code'=>1, 'message'=>'权限错误', 'a'=>[$path, $evts]]);
	    	exit;
		}
	}
}
