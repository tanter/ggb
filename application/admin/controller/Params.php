<?php
namespace app\admin\controller;
use app\common\controller\Auth;

class Params extends Auth
{
	private function returnLabel($fields=null){
		$arr = explode(',', $fields);
		$label = [
			'agent_rate' => '代理商返利',
			'c_tb_rate' => '提币手续费(%)',
			'c_tb_money' => '提币最低额度',
			'c_buy_rate' => '买入手续费(%)',
			'c_sell_rate'=> '卖出手续费(%)',
			'c_overnight_rate' => '隔夜手续费(%)',
			'c_spread' => '合约点差(%)',
			'c_profit_rate' => '止盈率(%)',
			'c_loss_rate' => '止亏率(%)',
			'c_open_rate' => '开仓手续费(%)',
			'c_close_rate' => '平仓手续费(%)',
            'nickname' => '昵称',
            'username' => '用户名',
            'password' => '密码',
            'phone' => '联系方式',
            'code'=>'我的推广码',
            'link'=>'链接',
            'email_host'=>'smtp服务器(必填)',
            'email_from'=>'发送者邮件地址(必填)',
            'email_fromname'=>'发送邮件昵称(非必填)',
            'email_username'=>'登录用户名(必填)',
            'email_password' => '授权码(必填)'
		];
		
		if(empty($fields)) return $label;
		$data = [];
		foreach ($arr as $index => $key) {
			$data[$key] = isset($label[$key]) ? $label[$key] : $key;
		}
		return $data;
	}
	private function returnParams($fields){
		return db('params')->where('id=1')->field($fields)->find();
	}
	// 保存参数
	public function save(){
		$data = request()->param();
		unset($data['token']);
		unset($data['path']);
		$table = input('table', 'params');
        unset($data['table']);

		db($table)->where('id=1')->update($data);
		return self::json(0, null, '保存成功');
	}
	// 短信
	public function getSms() {
		$fields = 'aliyun_accesskey_id,aliyun_accesskey_secret,aliyun_sign_name,aliyun_template_code';
		$pars = $this->returnParams($fields);
		$data = [
			'title' => '阿里云短信设置',
			'form' => $pars,
			'label' => $this->returnLabel($fields)
		];
		return self::json(0, $data);
	}
	// 邮箱设置
    public function getEmail()
    {
        $fields = 'email_host,email_from,email_fromname,email_username,email_password';
        $pars = $this->returnParams($fields);
        $data = [
            'title' => 'SMTP邮箱设置设置',
            'form' => $pars,
            'label' => $this->returnLabel($fields)
        ];
        return self::json(0, $data);
    }
	// 代理商分红
	public function getFh()
	{
		$fields = 'agent_rate';
		$pars = $this->returnParams($fields);
		$data = [
			'title' => '代理商分红比例,单位：%,保留两位小数',
			'form' => $pars,
			'label' => $this->returnLabel($fields)
		];
		return self::json(0, $data);
	}
	// 手续费设置
	public function getRate()
	{
		$fields = 'c_tb_rate,c_tb_money,c_overnight_rate,c_spread,c_profit_rate,c_loss_rate,c_open_rate,c_close_rate';
		$pars = $this->returnParams($fields);
		$data = [
			'title' => '手续费设置(保留2为小数)',
			'form' => $pars,
			'label' => $this->returnLabel($fields)
		];
		return self::json(0, $data);
	}

	// 获取代理商信息
    public function getInfo()
    {
        $token = input('token');
        $fields = input('fields');
        if(empty($fields)){
            $fields = 'nickname,username,password,phone';
            $from = db('admin')->field($fields)->where(['token'=>$token])->find();
            $from['password'] = '';
            $fields = $fields. ',password';
        }else{
            $from = db('admin')->field($fields)->where(['token'=>$token])->find();
            $from['link'] = $this->request->domain().'/index.html#/register?p='.$from['code'];
            $fields = $fields. ',link';
        }
        $data = [
            'title' => '',
            'form' => $from,
            'label' => $this->returnLabel($fields)
        ];
        return self::json(0, $data);
    }
}
