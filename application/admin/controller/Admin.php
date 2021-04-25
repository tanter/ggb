<?php
namespace app\admin\controller;
use app\common\controller\Auth;
use app\common\email\Exception;

class Admin extends Auth
{
	protected $ADMIN_FIELDS = "id, nickname,username,`password`,`phone`,`status`,add_time,code,auth";
	public function __construct()
	{
		parent::__construct();
	}
	// 添加账号
	public function addAccount()
	{
		try{
            $data = [
                'nickname' => input('nickname'),
                'username' => input('username'),
                'password' => input('password'),
                'phone' => input('phone'),
                'auth' => input('auth'),
                'add_time' => self::getDate()
            ];
            if(empty($data['nickname'])||empty($data['username'])||empty($data['password'])||empty($data['phone'])){
                return self::json(1, $data, '参数不能为空');
            }
            $data['password'] = md5($data['password']);
            if(db('admin')->where(['username'=>$data['username']])->value('id')){
                return self::json(1, '', '该用户名已存在');
            }
            db()->startTrans();
            $id = db('admin')->insertGetId($data);
            if ($id) {
                $admin = db('admin')->field($this->ADMIN_FIELDS)->where(['id'=>$id])->find();
                if($data['auth'] === 'agent'){
                    db('admin')->where(['id'=>$id])->update(['code'=>$this->create_invitation_code($id)]);

//                    $currency = db('currency')->select();
//                    $all = [];
//                    $time = self::getDate();
//                    foreach ($currency as $item) {
//                        $all[] = [
//                            'agent_id' => $id,
//                            'currency' => $item['name'],
//                            'type' => $item['type'],
//                            'total_money' => 0,
//                            'lock_money' => 0,
//                            'add_time' => $time
//                        ];
//                    }
//                    db('agent_asset')->insertAll($all);
                }
                db()->commit();
                return self::json(0, $admin, '添加成功');
            }
            return self::json(1, '', '添加失败');
        }catch (\Exception $e){
            db()->rollback();
            return self::json(2, '', '添加失败');
        }
	}
	// 获取账号
	public function getList()
	{
		$auth = input('auth', 'agent');
		$status = intval(input('status'));
		$username = input('username');
		$page  = input('page', 1);
		$limit = input('limit', 10);

		$sql = "select ".$this->ADMIN_FIELDS." from jyxt_admin where is_delete = 0";
		if($auth=='agent'){
		    $sql.= " and  auth = ?";
            $bind = [$auth];
        }else{
            $sql.= " and  auth<>'agent'";
        }

		if (in_array($status, [1, 2])) {
			$sql .= " and status = ? ";
			$bind[] = $status;
		}
		if (!empty($username)) {
			$username = trim($username);
			$sql .= " and username like '%$username%'";
		}
		$sql .= " order by id desc limit ?,?";
		$bind[] = ($page - 1)*$limit;
		$bind[] = $limit;

		$list = db()->query($sql, $bind);
		foreach ($list as $index => $item) {
			$list[$index]['count'] = db('user')->where(['p_id'=>intval($item['id'])])->count();
		}
		$total =db('admin')->where(['auth'=>$auth, 'is_delete'=>0])->count();
		return self::json(0, [
			'list'=>$list,
			'total'=>$total
		]);
	}
	// 编辑账号
	public function editAccount()
	{
		$data = $this->params();
		if(isset($data['username'])&&db('admin')->where(['username'=>$data['username']])->find()){
            return self::json(1, null, '该账号已存在');
        }
		if(isset($data['password'])) $data['password'] = md5($data['password']);
		if (db('admin')->update($data)) {
			return self::json(0, null, '操作成功');
		}
		return self::json(1, null, '操作失败');
	}

	// excel表格
	public function excel(){
		$phone = input('phone'); 
		$sql = "select * from jyxt_user where 1=1";

		if(!empty($phone)) {
			$sql .= " and phone like '%$phone%'";
		}
		$data = db()->query($sql);
		$url = self::createExcel($data,[
				'id'=>'编号',
				'phone'=>'用户手机号',
				'email'=>'用户邮箱',
				'transaction_account'=>'法币交易账号',
				'bank_name'=>'银行卡所在行',
				'bank_number'=>'银行卡号',
				'alipay_account'=>'支付宝账号',
				'weixin_nickname'=>'微信昵称',
				'weixin_account'=>'微信账号',
				'is_lock'=>'是否锁定',
				'id_card'=>'身份证号'
			], time(),[],null,true);

		return self::json(0, ['url'=>$url]);
	}
}
