<?php
namespace app\admin\controller;
use app\common\controller\Auth;

class User extends Auth
{
	public function __construct()
	{
		parent::__construct();
	}
	// 获取用户列表
	public function getList()
	{
		$phone = input('phone'); 
		$page  = input('page', 1);
		$limit = input('limit', 10);
		$agent_id = $this->getAgentId();

		$user_id = intval(input('user_id'));

		$sql = "select a.* ,b.`name` as realname,CONCAT(c.username,'(',c.nickname,')') as pname
                from jyxt_user a
                LEFT JOIN jyxt_user_id_card b on b.user_id = a.id and b.is_auth = 1 and b.is_delete = 0
                left join jyxt_admin c on c.id = a.p_id and auth='agent'
                where a.is_delete = 0";
		if(!empty($agent_id)){
			$sql .= " and a.p_id = $agent_id";
		}
		if(!empty($phone)) {
			if(strstr($phone,'@')){
				$sql .= " and a.email like '%$phone%'";
			}else{
				$sql .= " and a.phone like '%$phone%'";
			}
		}
		if($agent_id){
            $total = count(db()->query($sql));
        }else{
            $total = db('user')->count();
        }

		$sql.= " order by a.id desc limit ?, ?";

		$list = db()->query($sql, [($page - 1)*$limit, $limit]);

		return self::json(0, [
				'list'=>$list,
				'total'=>$total
			]);
	}
	// 是否锁定
	public function isLock()
	{
		$is_lock = input('is_lock', 0);
		$id = input('id');
		db('user')->where(['id'=>intval($id)])->update(['is_lock'=>$is_lock]);
		return self::json(0, [], '操作成功');
	}
	// 删除
	public function userDelete()
	{
		$is_delete = input('is_delete', 0);
		$id = input('id');
		db('user')->where(['id'=>intval($id)])->update(['is_delete'=>$is_delete]);
		return self::json(0, [], '操作成功');
	}
	// 编辑
	public function userEdit() {
		$data = $this->params();
		if(isset($data['type']) && $data['type']=='bh'){
		    unset($data['type']);
		    db('user_id_card')->update($data);
        }else{
            if(isset($data['password']))$data['password'] = md5($data['password']);
            db('user')->update($data);
        }
		return self::json(0, [], '操作成功');
	}
	// 获取用户钱包
	public function getWalletList()
	{
		$uid = intval(input('user_id'));
		$agent_id = $this->getAgentId();
		$condition['id'] = $uid;
        if(!empty($agent_id)){
            $condition['p_id'] = $agent_id;
        }
		$usdt = db('user')->field('"USDT" as currency, id as user_id, bb_usdt,bb_usdt_lock,hy_usdt,hy_usdt_lock,add_time')->where($condition)->find();

		$sql = "SELECT a.id, a.user_id,a.currency,a.positions as bb_usdt,a.positions_lock as bb_usdt_lock,b.address,a.add_time
                    FROM jyxt_user_wallet a LEFT JOIN jyxt_user c on c.id = a.user_id
                    , jyxt_currency b
                    where a.user_id = ?
                    and a.type = 1
                    and b.type = 1
                    and b.`name` = a.currency
                    and b.`status` = 0";
		if(!empty($agent_id)){
			$sql .= " and c.p_id = $agent_id";
		}
		$wallet = db()->query($sql, [$uid]);
        array_unshift($wallet, $usdt);
		return self::json(0, ['list' => $wallet]);
	}
	// 用户钱包删除
	public function walletDelete()
	{
		$is_delete = input('is_delete', 0);
		$uid = input('user_id');
		$currency = input('currency');
		db('user_wallet')->where(['user_id'=>intval($uid), 'currency'=>$currency])->update(['is_delete'=>$is_delete]);
		return self::json(0, [], '操作成功');
	}
	// 用户钱包编辑
	public function walletEdit()
	{
		$uid = intval(input('user_id'));
		$field = input('field');                 //
		$arr = explode('||', $field);            // 0 = [1,2] 币种分类  1 = [balance, lock_balance] 字段
		$number = floatval(input('number'));
		$message = input('message');
		$type = input('type');
		$currency = input('currency');
		if(empty($field)) {
			return self::json(0, [], '请选择调节账户');
		}
		if ($type == '0') $number = 0 - $number;
		$wallet = db('user_wallet')->where(['user_id'=>$uid, 'type'=>$arr[0], 'currency'=>$currency])->find();
		$old_value = $wallet[$arr[1]];
		$new_value = $old_value + $number;
		$update[$arr[1]] = $new_value;
		db('user_wallet')->where(['id'=>intval($wallet['id'])])->update($update);

		db('user_wallet_log')->insert([
			'gl_id' =>self::get_admin_id(input('token')),
			'user_id' => $uid,
			'money' => $number,
			'add_time' => self::getDate(),
			'message'=>$message,
			'ramark' => $field.'||'.$old_value,
			'type' => -1
		]);
		return self::json(0, [], '调节成功');
	}
	// 获取用户身份证信息
	public function getIdCradList()
	{
		$page  = input('page', 1);
		$limit = input('limit', 10);
		$agent_id = $this->getAgentId();

		$phone = input('phone');
		$sql = "select a.* , IFNULL(b.phone, b.email) as phone
				from jyxt_user_id_card a
				LEFT JOIN jyxt_user b on b.id = a.user_id
				where a.is_delete=0";
		if(!empty($agent_id)){
			$sql .= " and b.p_id = $agent_id";
		}
		
		if(!empty($phone)) {
			if(strstr($phone,'@')){
				$sql .= " and b.email like '%$phone%'";
			}else{
				$sql .= " and b.phone like '%$phone%'";
			}
		}
        $total = db()->query($sql);

		$sql.= " order by a.id desc limit ?, ?";

		$list = db()->query($sql, [($page - 1)*$limit, $limit]);

		//$total = db('user_id_card')->where('is_delete = 0')->count();
		return self::json(0, [
			'list'=>$list,
			'total'=>count($total)
		]);
	}
	// 删除认证
	public function delIdCard()
	{
		$id = intval(input('id'));
		db('user_id_card')->where(['id'=>$id])->update(['is_delete'=>1]);
		return self::json(0, null, '操作成功');
	}
	// 是否审核
	public function isAuth()
	{
		$is_lock = input('is_lock', 0);
		$id = input('id');
		if($is_lock == 1) {
			$db = db('user_id_card')->field('num, user_id')->where(['id'=>intval($id)])->find();
			db('user')->where(['id'=>intval($db['user_id'])])->update(['id_card'=>$db['num']]);
		}
		db('user_id_card')->where(['id'=>intval($id)])->update(['is_auth'=>$is_lock]);
		return self::json(0, [], '操作成功');
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

	public function getUserOrderList()
	{
		$type = intval(input('type'));
		$name = input('phone');
		$currency = input('currency');
		$page  = input('page', 1);
		$limit = input('limit', 10);
		$phone = input('phone');

		$sql = "select a.* , IFNULL(b.phone,b.email) phone
				from jyxt_user_deal a
				LEFT JOIN jyxt_user b on b.id = a.user_id 
				where 1=1 
				and a.deal_type = ?";
		$bind[] = $type;

		if(!empty($name)){
			$sql .= " and b.`phone` like '%$name%'";
		}

		if(!empty($currency)){
			$sql .= " and a.`currency` = ?";
			$bind[] = $currency;
		}


		$total = db()->query($sql, $bind);

		$sql.= " order by a.id desc limit ?, ?";
		$bind[] = ($page - 1)*$limit;
		$bind[] = $limit;

		$list = db()->query($sql, $bind);

		
		return self::json(0, [
			'list'=>$list,
			'total'=>count($total)
		]);
	}

	public function getCurrency()
	{
		$type = intval(input('type'));
		$condition = [
			'type' => $type
		];
		$list = db('currency')->where($condition)->select();

		return self::json(0, [
			'list'=>$list
		]);
	}

	public function editCurrency()
	{
		$id = intval(input('id'));
		$key = input('key');
		$value = input('value');
		$deal_rate = input('deal_rate');
		$settlement_rate = input('settlement_rate');
        $lot = input('lot');
        $address = input('address');
		if(!empty($key) && in_array($value, [0,1])){
			$update[$key] = $value;
		}
		if(!empty($deal_rate)){
			$update['deal_rate'] = $deal_rate;
		}
		if(!empty($settlement_rate)){
			$update['settlement_rate'] = $settlement_rate;
		}
		if(!empty($lot)){
            $update['lot'] = $lot;
        }
        if(!empty($address)){
            $update['address'] = $address;
        }
		if(isset($update)){
			db('currency')->where(['id'=>$id])->update($update);
		}
		return self::json(0, '', '操作成功');
	}
	// 添加合约设置
	public function addSetting()
	{
		$classify = intval(input('classify'));
		$type = intval(input('type', 2));
		$value = input('value');
		$data = [
				'type' => $type,
				'is_delete' => 0,
				'classify' => $classify,
				'value' => $value
			];
		$id = db('currency_setting')->insertGetId($data);
		$data['id'] = $id;
		return self::json(0, $data, '添加成功');
	}
	// 编辑合约
	public function editSetting()
	{
		$id = intval(input('id'));
		$classify = intval(input('classify'));
		$value = input('value');
		$is_delete = input('is_delete');
		$update['id'] = $id;
		if(!empty($classify)){
			$update['classify'] = $classify;
		}
		if(!empty($value)){
			$update['value'] = $value;
		}
		if(!empty($is_delete)){
			$update['is_delete'] = $is_delete;
		}
		db('currency_setting')->update($update);
		return self::json(0, '', '操作成功');
	}
	// 获取合约设置
	public function getSetting()
	{
		$data = db('currency_setting')->where(['is_delete'=>0])->select();
		foreach ($data as $index => $item) {
			$data[$index]['classify_text'] = $item['classify'] == 1 ? '倍数' : '手数';
		}
		return self::json(0, $data);
	}

	// 获取用户充值记录
	public function getUserRechargeList()
	{
		$sql = "select a.*,c.`name`,b.phone,b.email
                from jyxt_user_wallet_recharge a
                LEFT JOIN jyxt_user b on b.id = a.user_id
                LEFT JOIN jyxt_user_id_card c on c.user_id = b.id and c.is_auth = 1
                where a.status <> -1";
		$page  = input('page', 1);
		$limit = input('limit', 10);

		$phone = input('phone');
		$currency = input('currency');

		if(!empty($phone)){
			if(!empty(intval($phone))){
				$sql .= " and b.phone like '%$phone%'";
			}else{
				$sql .= " and b.`name` like '%$phone%'";
			}
		}
		if(!empty($currency)){
			$sql .= " and a.currency = '$currency'";
		}
		$total = db()->query($sql);

		$sql .= " order by a.status asc limit ? ,?";

		$list = db()->query($sql, [($page - 1)*$limit, $limit]);

		return self::json(0, ['list'=>$list, 'total'=>count($total)]);
	}
	// 确认充值
	public function ensureRecharge()
	{
		$id = intval(input('id'));
		$reg = db('user_wallet_recharge')->where(['id'=>$id])->find();
		if(empty($reg)){
			return self::json(1, '', '充值记录不存在');
		}
		if($reg['status'] != 0){
			return self::json(1, '', '已充值');
		}
		$money = $reg['money'];

		if($reg['currency'] == 'USDT'){
		    $keys = $reg['type'] == 1 ? 'bb_usdt' : 'hy_usdt';
            if(db('user')->where(['id'=>$reg['user_id']])->setInc($keys, $money)){
                db('user_wallet_recharge')->where(['id'=>$id])->update(['status'=>1]);
                return self::json(0, '', '操作成功');
            }
        }else{
            $condition = [
                'user_id' => $reg['user_id'],
                'type' => $reg['type'],
                'currency' => $reg['currency']
            ];
            if(db('user_wallet')->where($condition)->setInc('positions', $money)){
                db('user_wallet_recharge')->where(['id'=>$id])->update(['status'=>1]);
                return self::json(0, '', '操作成功');
            }
        }
		return self::json(1, '', '操作失败');
	}
	public function editRecharge()
	{
		$id = intval(input('id'));
		$money = floatval(input('money'));
		$update['id'] = $id;
		$update['money'] = $money;
		db('user_wallet_recharge')->update($update);
		return self::json(0, '', '操作成功');
	}
	public function delRecharge()
	{
		$id = intval(input('id'));
		$update['id'] = $id;
		$update['status'] = -1;
		db('user_wallet_recharge')->update($update);
		return self::json(0, '', '操作成功');
	}

	// 获取提币地址列表
	public function getTakeList()
	{
		$sql = "select a.*,c.`name`,b.phone,b.email
                from jyxt_user_wallet_take a
                LEFT JOIN jyxt_user b on b.id = a.user_id
                LEFT JOIN jyxt_user_id_card c on c.user_id = b.id and c.is_auth = 1
                where a.`status` <> -1";

		$page  = input('page', 1);
		$limit = input('limit', 10);
		
		$phone = input('phone');
		$currency = input('currency');

		if(!empty($phone)){
			if(!empty(intval($phone))){
				$sql .= " and b.phone like '%$phone%'";
			}else{
				$sql .= " and b.`name` like '%$phone%'";
			}
		}
		if(!empty($currency)){
			$sql .= " and a.currency = '$currency'";
		}
		$total = db()->query($sql);

		$sql .= " order by a.id desc limit ? ,?";

		$list = db()->query($sql, [($page - 1)*$limit, $limit]);

		return self::json(0, ['list'=>$list, 'total'=>count($total)]);
	}
	public function editTakeList()
	{
		$id = intval(input('id'));
		$ssss = db('user_wallet_take')->where(['id'=>$id])->value('status');
		if($ssss == 1){
			return self::json(0, '', '该记录已提现');
		}
		$update['id'] = $id;
		$status = intval(input('status'));
		$money = floatval(input('money'));
		$address = input('address');
		if(!empty($status)){
			$update['status'] = $status;
		}
		if(!empty($money)){
			$update['money'] = $money;
		}
		if(!empty($address)){
			$update['address'] = $address;
		}

		$update['id'] = $id;

		db('user_wallet_take')->update($update);
		return self::json(0, '', '操作成功');
	}

//	// 获取实时资金监控
//	public function getNowList()
//	{
//		$sql = "select a.* , b.`name`,b.phone,b.email,b.p_id
//				from jyxt_user_wallet_c a
//				LEFT JOIN jyxt_user b on b.id = a.user_id
//				where 1=1 ";
//		$page  = input('page', 1);
//		$limit = input('limit', 10);
//		$phone = input('phone');
//		$currency = input('currency');
//		if(!empty($phone)){
//			if(!empty(intval($phone))){
//				$sql .= " and b.phone like '%$phone%'";
//			}else{
//				$sql .= " and b.`name` like '%$phone%'";
//			}
//		}
//		if(!empty($currency)){
//			$sql .= " and a.currency = '$currency'";
//		}
//		$total = db()->query($sql);
//		$sql .= " order by a.id desc limit ? ,?";
//		$list = db()->query($sql, [($page - 1)*$limit, $limit]);
//
//		foreach ($list as $index=>$item){
//		    $condition = ['user_id'=>$item['user_id'],'currency'=>$item['currency']];
//		    // 累加浮动盈亏
//		    $list[$index]['floating_pl'] = db('user_deal_lines_c_h')->where($condition)->sum('floating_pl');
//
//		    $c = db('user_deal_lines_c')->where($condition)->select();
//		    // 累加开仓手续费
//            $list[$index]['open_fee'] = 0;
//            // 累加平仓手续费
//            $list[$index]['close_fee'] = 0;
//            // 累加持仓手续费
//            $list[$index]['position_fee'] = 0;
//            // 平仓盈亏
//            $list[$index]['profit_loss'] = 0;
//            foreach ($c as $item){
//                // 累加开仓手续费
//                $list[$index]['open_fee'] += $item['open_fee'];
//                // 累加平仓手续费
//                $list[$index]['close_fee'] += $item['close_out_fee'];
//                // 累加持仓手续费
//                $list[$index]['position_fee'] += $item['overnight_fee'];
//                $list[$index]['profit_loss'] += $item['profit_loss'];
//            }
//        }
//		return self::json(0, ['list'=>$list, 'total'=>count($total)]);
//	}
    // 获取实时资金监控
    public function getNowList()
    {
        $sql = "select a.user_id,a.currency, sum(a.open_fee) as open_fee,sum(a.close_out_fee) as close_fee,sum(a.overnight_fee) as position_fee,sum(a.profit_loss) as profit_loss 
                ,b.id,b.p_id,b.phone,b.email
                from jyxt_user_deal_lines_c a
                LEFT JOIN jyxt_user b on b.id = a.user_id
                where b.id <> ''";
        $page  = input('page', 1);
        $limit = input('limit', 10);
        $phone = input('phone');
        $currency = input('currency');
        $agent_id = $this->getAgentId();
        if($agent_id){
            $sql .= " and b.p_id = $agent_id";
        }

        if(!empty($phone)){
            if(!empty(intval($phone))){
                $sql .= " and b.phone like '%$phone%'";
            }else{
                $sql .= " and b.`name` like '%$phone%'";
            }
        }
        if(!empty($currency)){
            $sql .= " and a.currency = '$currency'";
        }
		$sql2 = $sql.' group by a.user_id';
        $total = db()->query($sql);
        $sql .= " group by a.user_id order by a.id desc limit ? ,?";
      	      //	dump($sql);
        $list = db()->query($sql, [($page - 1)*$limit, $limit-1]);

        foreach ($list as $index=>$item){
            // 获取风险率
            //$list[$index]['hazard_rate'] =round($item['floating_pl'] / $item['margin'] * 100, 4) .'%';
              
            $condition = ['user_id'=>$item['id'],'currency'=>$item['currency']];
            $list[$index]['open_fee'] = round($item['open_fee'], 4);
            $list[$index]['close_fee'] = round($item['close_fee'], 4);
            $list[$index]['position_fee'] = round($item['position_fee'], 4);
            $list[$index]['profit_loss'] = round($item['profit_loss'], 4);


            // 累加浮动盈亏
            $list[$index]['floating_pl'] = round(db('user_deal_lines_c_h')->where($condition)->sum('floating_pl'), 4);
        }
        return self::json(0, ['list'=>$list, 'total'=>count($total)]);
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

	// 获取合约交易订单明细
	public function getContractOrderDetail()
	{
        /**
            index: 0
            page: 1
            limit: 10
            phone: 110
            currency: BTC
            price_type: 1
            type_status: 1
            start_time: 2019-08-07T16:00:00.000Z
            end_time: 2019-08-08T16:00:00.000Z
         */
        $index = intval(input('index')); //  ["当前委托", "当前持仓", "已成交", "已撤单"],
        $page  = input('page', 1);
        $limit = input('limit', 10);
        $phone = input('phone');
        $currency = input('currency');
        $price_type =intval(input('price_type'));  // 0全部  1市价  2限价
        $type_status = intval(input('type_status')); //0 全部  1买多   2平多   3卖空   4 平空
        $start_time = input('start_time');
        $end_time = input('end_time');
        $agent_id = $this->getAgentId();

        if($index == 0){
            // 当前委托
            $sql = "select a.*,IFNULL(b.phone,b.email) phone
                    from jyxt_user_deal a
                    LEFT JOIN jyxt_user b on b.id = a.user_id
                    where a.`status` = 0";
        }else if($index == 1){
          	// 持仓
            $sql = "select a.*,IFNULL(b.phone,b.email) phone
                    from jyxt_user_deal_lines_c_h a
                    LEFT JOIN jyxt_user b on b.id = a.user_id
                    where type in (1,2)";
        }else if($index == 2){
          	// 已成交
            $sql = "select a.*,IFNULL(b.phone,b.email) phone
                    from jyxt_user_deal_lines_c a
                    LEFT JOIN jyxt_user b on b.id = a.user_id
                    where type in (3,4)";
        }else if($index == 3) {
            // 已平仓
            $sql = "select a.*,IFNULL(b.phone,b.email) phone
                    from jyxt_user_deal_lines_c_h a
                    LEFT JOIN jyxt_user b on b.id = a.user_id
                    where type in (3,4)";
        }
        else{
            // 已撤单
            $sql = "select a.*,IFNULL(b.phone,b.email) phone
                    from jyxt_user_deal a
                    LEFT JOIN jyxt_user b on b.id = a.user_id
                    where a.`status` = 2";
        }
        if($agent_id){
            $sql .= " and b.p_id = $agent_id";
        }
		if(!empty($phone)){
			if(!empty(intval($phone))){
				$sql .= " and b.phone like '%$phone%'";
			}else{
				$sql .= " and b.email like '%$phone%'";
			}
		}
		if(!empty($currency)){
			$sql .= " and a.currency = '$currency'";
		}
		if(!empty($price_type)){
            $sql .= " and a.price_type = $price_type";
        }
        if(!empty($type_status)){
            if($index == 0 || $index == 4) {
                $sql .= " and a.mark = $type_status";
            }else{
                $sql .= " and a.type = $type_status";
            }
        }
        if(!empty($start_time)||!empty($end_time)){
            $fd = self::timeInit($start_time,$end_time);
            $start_time = $fd[0];
            $end_time = $fd[1];
            $sql .= " and a.time between '$start_time' and '$end_time'";
        }
		$total = db()->query($sql);

		$sql .= " order by a.id desc limit ? ,?";

		$list = db()->query($sql, [($page - 1)*$limit, $limit]);

        if($index == 0 || $index == 4){
            foreach ($list as $index => $item){
                $list[$index]['type_text'] = ['买入做多', '卖出做空', '卖出平多', '买入平空'][$item['mark'] - 1];
                // 止盈  止亏 保证金
                $list[$index]['stop_profit'] = 0;
                $list[$index]['stop_loss'] = 0;
                $list[$index]['margin'] = 0;
                $list[$index]['now_price'] = $this->get_currency_jy_value($item['currency'],2,2,'value');

                $c = db('user_deal_lines_c')->where(['deal_id'=>$item['id']])->select();

                foreach ($c as $i){
                    $list[$index]['stop_profit'] += $i['stop_profit'];
                    $list[$index]['stop_loss'] += $i['stop_loss'];
                    $list[$index]['margin'] += $i['margin'];
                }
                $list[$index]['stop_profit'] = round($list[$index]['stop_profit'],4);
                $list[$index]['stop_loss'] = round($list[$index]['stop_loss'],4);
                $list[$index]['margin'] = round($list[$index]['margin'],4);
            }
            $hz = [];
        }else{
//            $hz = [
//                'title'=>'汇总',
//                'margin'=>0,
//                'amount'=>0,
//                'overnight_fee'=>0,
//                'floating_pl'=>0
//            ];
            foreach ($list as $index => $item) {
              	if($index == 1){
                	$list[$index]['hazard_rate'] = $item['margin'] == '0' ? '0' :round($item['floating_pl'] / $item['margin'] * 100, 4) .'%';
                }
              
              
                // 买入做多2 卖出做空3 卖出平多4 买入平空
                // 当前价格
                $list[$index]['now_price'] = $this->get_currency_jy_value($item['currency'],2,2,'value');
                $list[$index]['type_text'] = ['买入做多', '卖出做空', '卖出平多', '买入平空'][$item['type'] - 1];
                if(isset($item['is_blow']) && in_array($item['type'], [3,4])){
                    $list[$index]['is_blow_text'] = $item['is_blow'] === 0 ? '已平仓' : '爆仓';
                }
//                $hz['margin'] += $item['margin'];
//                $hz['amount'] += $item['amount'];
//                $hz['overnight_fee'] += $item['overnight_fee'];
//                $hz['floating_pl'] += $item['floating_pl'];
              	$list[$index]['open_proce'] = $item['open_price'];
              
                $lot = $this->get_deal_rate(2, $item['currency'], 'lot');
            	$position = $item['position'] / $lot;
              	$list[$index]['amount'] = round($position);
            }
        }
		return self::json(0, ['list'=>$list, 'total'=>count($total)]);
	}
      // 获取币种的交易手续费
    private function get_deal_rate($type, $currency, $value)
    {
        return db('currency')->where(['type' => $type, 'name' => $currency])->value($value);
    }
}
