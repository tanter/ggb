<?php
namespace app\admin\controller;
use app\common\controller\Auth;

class Agent extends Auth
{
    public function __construct()
    {
        parent::__construct();
    }

//    // 交易详情
//	public function getDealLines()
//	{
//		$page = input('page');
//		$limit= input('limit');
//		$phone= input('phone');
//		$start_time = input('start_time');
//		$end_time = input('end_time');
//		$agent_id = $this->getAgentId();
//
//		$times = $this->timeInit($start_time, $end_time);
//
//		$sql = "select m.username,m.nickname,m.phone as tel,a.id as lid,a.money,a.add_time, b.*,c.`name`,c.phone,c.email
//				from jyxt_agent_deal_lines a
//				LEFT JOIN jyxt_admin m on m.id = a.agent_id
//				LEFT JOIN jyxt_user_deal b on b.id = a.deal_id
//				LEFT JOIN jyxt_user c on c.id = b.user_id
//				where 1 = 1";
//		if($agent_id){
//			$sql .= " and c.p_id = $agent_id";
//		}
//		if(!empty($phone)){
//			$sql.= " and m.phone like '%$phone%'";
//		}
//		$stime = $times[0];
//		$etime = $times[1];
//		$sql .= " and a.add_time between '$stime' and '$etime'";
//		$total = db()->query($sql);
//
//		$first = ($page - 1) * $limit;
//		$sql .= " order by a.id desc limit $first,$limit";
//		$data = db()->query($sql);
//
//		return self::json(0, ['list'=>$data, 'total'=>count($total)]);
//	}
// 交易详情
    public function getDealLines()
    {
        $page  = input('page', 1);
        $limit = input('limit', 10);
        $agent_id = $this->getAgentId();

        $phone = input('phone');
        $sql = "select a.* , b.phone, b.username,b.nickname
				from jyxt_agent_take a
				LEFT JOIN jyxt_admin b on b.id = a.agent_id
				where a.is_delete=0
				and b.auth = 'agent'
				and a.`status`  = 2";

        $balance = 0;
        if($agent_id){
            $sql .= " and b.id = $agent_id and a.status <> -1";
            $balance = db('admin')->where(['id' => $agent_id])->value('usdt');
        }

        if(!empty($phone)) {
            if(!empty(intval($phone))){
                $sql .= " and b.phone like '%$phone%'";
            }else{
                $sql .= " and b.username like '%$phone%'";
            }
        }

        $total = db()->query($sql);

        $sql.= " order by a.id desc limit ?, ?";

        $list = db()->query($sql, [($page - 1)*$limit, $limit]);

        return self::json(0, [
            'list'=>$list,
            'total'=>count($total),
            'balance' => $balance
        ]);
    }
    // 代理资产管理
    public function getAssetList()
    {
        $page = input('page');
        $limit = input('limit');
        $phone= input('phone');
        $agent_id = $this->getAgentId();

        $sql = "select * from jyxt_admin where auth ='agent' and `status` = 1 and is_delete = 0";
        if($agent_id){
            $sql .= " and id = $agent_id";
        }
        if(!empty($phone)) {
            if(!empty(intval($phone))){
                $sql .= " and phone like '%$phone%'";
            }else{
                $sql .= " and username like '%$phone%'";
            }
        }
        $total = db()->query($sql);

        $first = ($page - 1) * $limit;
        $sql .= " order by id desc limit $first, $limit";

        $data = db()->query($sql);
        return self::json(0, ['list' => $data, 'total'=>count($total)]);
    }
    // 获取代理商报表
    public function getAssetReport()
    {
        $page = input('page');
        $limit= input('limit');
        $phone= input('phone');
        $start_time = input('start_time');
        $end_time = input('end_time');
        $agent_id = $this->getAgentId();

        $sql = "select * from jyxt_admin where auth ='agent' and `status` = 1 and is_delete = 0";
        if($agent_id){
            $sql .= " and id = $agent_id";
        }
        if(!empty($phone)) {
            if(!empty(intval($phone))){
                $sql .= " and phone like '%$phone%'";
            }else{
                $sql .= " and username like '%$phone%'";
            }
        }
        $total = db()->query($sql);
        $first = ($page - 1) * $limit;
        $sql .= " order by id desc limit $first, $limit";
        $data = db()->query($sql);
        //1币币交易
        //2合约开仓
        //3合约平仓
        //4合约隔夜费
        $times = $this->timeInit($start_time, $end_time);
        $start_time = $times[0];
        $end_time = $times[1];

        foreach ($data as $index=>$item)
        {
            // 币币总的手续费
            $pid = $item['id'];
            $bbsql = "select IFNULL(SUM(fee),0) as fee
                        from  jyxt_user_deal_lines a LEFT JOIN jyxt_user b on  b.id = a.user_id
                        where b.p_id = $pid and a.time between '$start_time' and '$end_time'";
            $data[$index]['bb_fee'] = db()->query($bbsql)[0]['fee'];
            // 合约总的手续费

            $hysql = "SELECT SUM(a.fee) as fee from (select IFNULL(SUM(close_out_fee),0) as fee
                        from  jyxt_user_deal_lines_c_h a 
                        LEFT JOIN jyxt_user b on  b.id = a.user_id
                        where b.p_id = $pid
                        and a.time between '$start_time' and '$end_time'
                        UNION
                        select SUM(a.money) as fee
                        from jyxt_user_wallet_log a 
                        LEFT JOIN jyxt_user_deal_lines_c_h b on b.id = a.gl_id
                        LEFT JOIN jyxt_user c on c.id = b.user_id
                        where a.type = 13 
                        and c.p_id = $pid
                        and a.add_time between '$start_time' and '$end_time') a";
            $data[$index]['hy_fee'] = db()->query($hysql)[0]['fee'];
        }
        return self::json(0, [
            'list'=>$data,
            'total'=>count($total)
        ]);
    }

    public function getAgentTakeList()
    {
        $page  = input('page', 1);
        $limit = input('limit', 10);
        $agent_id = $this->getAgentId();

        $phone = input('phone');
        $sql = "select a.* , b.phone, b.username
				from jyxt_agent_take a
				LEFT JOIN jyxt_admin b on b.id = a.agent_id
				where a.is_delete=0
				and b.auth = 'agent'
				and a.`status` = 0
				and a.type = 1";

        $balance = 0;
        if($agent_id){
            $sql .= " and b.id = $agent_id and a.status <> -1";
            $balance = db('admin')->where(['id' => $agent_id])->value('usdt');
        }

        if(!empty($phone)) {
            if(!empty(intval($phone))){
                $sql .= " and b.phone like '%$phone%'";
            }else{
                $sql .= " and b.username like '%$phone%'";
            }
        }

        $total = db()->query($sql);

        $sql.= " order by a.id desc limit ?, ?";

        $list = db()->query($sql, [($page - 1)*$limit, $limit]);

        return self::json(0, [
            'list'=>$list,
            'total'=>count($total),
            'balance' => $balance
        ]);
    }
    // 代理添加提币申请
    public function addAgentTake()
    {
        $agent_id = $this->getAgentId();
        try{
            $address = input('address');
            $money = input('money');

            $admin = db('admin')->field('usdt, usdt_lock')->where(['id'=>$agent_id])->find();
            if($admin['usdt'] < $money){
                return self::json(1, null, '余额不足');
            }

            $c_tb_money = db('params')->where('id=1')->value('c_tb_money');
            if($money < $c_tb_money){
                return self::json(1, null, '最低提币数量'.$c_tb_money);
            }

            $rate = db('params')->where('id=1')->value('c_tb_rate');
            $fee = round($money * $rate / 100, 8);

            $id = db('agent_take')->insertGetId([
                'agent_id' => $agent_id,
                'address' => $address,
                'money' => $money,
                'fee'=>$fee,
                'time' => self::getDate()
            ]);
            if($id){
                db('admin')->where(['id'=>$agent_id])->update([
                    'usdt' => self::round($admin['usdt'] - $money - $fee, 8),
                    'usdt_lock' => self::round($admin['usdt_lock'] + $money + $fee, 8)
                ]);
            }
            $res = db('agent_take')->where(['id' => $id])->find();
            $res['usdt'] = db('admin')->where(['id'=>$agent_id])->value('usdt');
            return self::json(0, $res,'申请成功');
        }catch (Exception $e) {
            return self::json(0, null, '添加失败', $e->getMessage());
        }
    }
    // 代理撤销提币申请
    public function calcelAgentTake()
    {
        $id = intval(input('id'));
        try{
            $take = db('agent_take')->where(['id'=>$id])->find();
            db('agent_take')->where(['id'=>$id])->update(['status'=>-1]);

            $admin = db('admin')->field('total_money, lock_money, id')->where(['id' => intval($take['agent_id'])])->find();

            db('admin')->where(['id' => intval($admin['id'])])->update([
                'total_money' => self::round($admin['total_money'] + $take['money'], 8),
                'lock_money' => self::round($admin['lock_money'] - $take['money'], 8)
            ]);
            return self::json(0, null, '操作成功');
        }catch (Exception $e) {
            return self::json(0, null, '撤销失败', $e->getMessage());
        }
    }

    public function isAuth()
    {
        $id = intval(input('id'));
        $status = intval(input('status'));
        $key = input('key');
        $update[$key] = $status;
        db('agent_take')->where(['id'=>$id])->update($update);
        return self::json(0, null, '操作成功');
    }
    private function getHomeCacheKey($agent_id)
    {
        if($agent_id) return 'home_agent_data_statistics_'.$agent_id;
        else return 'home_data_statistics';
    }
    // 首页获取统计
    public function home()
    {
        $agent_id = $this->getAgentId();
        $key = $this->getHomeCacheKey($agent_id);
        $data = cache($key);

        if(!empty($data)){
            return self::json(0, json_decode($data, true));
        }
        $yesterday_time_stamp = self::yesterday_time_stamp();
        $today_time_stamp = self::today_time_stamp();

        $dbUser = db('user');

        $condition = [];
        if($agent_id){
            $condition['p_id'] = $agent_id;
        }

        $count = $dbUser->where($condition)->count();
        $condition['time_stamp'] = $yesterday_time_stamp;
        $yesterday_count = $dbUser->where($condition)->count();
        $condition['time_stamp'] = $today_time_stamp;
        $today_count = $dbUser->where($condition)->count();

        $condition['id_card'] = ['id', '<>', ''];
        $count2 = $dbUser->where($condition)->count();
        $condition['time_stamp'] = $yesterday_time_stamp;
        $yesterday_count2 = $dbUser->where($condition)->count();
        $condition['time_stamp'] = $today_time_stamp;
        $today_count2 = $dbUser->where($condition)->count();

        $user = [
            'theader' => ['会员类型' , '累计', '昨日新增', '今日新增'],
            'tbody' => [
                ['注册用户', $count, $yesterday_count, $today_count],
                ['实名用户', $count2, $yesterday_count2, $today_count2]
            ]
        ];
        // 合约总交易额度
        $sql = "select a.amount, a.total,a.open_fee,UNIX_TIMESTAMP(a.time) as time
                from jyxt_user_deal_lines_c a
                LEFT JOIN jyxt_user b on b.id = a.user_id
                where 1=1";
        if($agent_id){
            $sql .= " and b.p_id = $agent_id";
        }
        $sql .=" UNION ALL ";
        $sql .= "select 0 as amount,0 as total,a.money as fee,UNIX_TIMESTAMP(a.add_time) as time
                from jyxt_user_wallet_log a
                LEFT JOIN jyxt_user b on b.id = a.user_id
                where type in (12,13)";
        if($agent_id){
            $sql .= " and b.p_id = $agent_id";
        }
        $data = db()->query($sql);
        $amount = 0;
        $total = 0;
        $fee = 0;
        $yesterday_total = 0;
        $yesterday_fee = 0;
        $today_total = 0;
        $today_fee = 0;

        foreach ($data as $item)
        {
            $amount += $item['amount'];
            $total += $item['total'];
            $fee += $item['open_fee'];
            if($item['time'] == $yesterday_time_stamp){
                $yesterday_total += $item['total'];
                $yesterday_fee += $item['open_fee'];
            }
            if($item['time'] == $today_time_stamp){
                $today_total += $item['total'];
                $today_fee += $item['open_fee'];
            }
        }

        $currency = [
            'title' => '合约交易',
            'theader' => [
                [ 'title' => '合约币交易总量', 'value' => $amount, 'class'=>'red' ],
                [ 'title' => '总交易额', 'value' => $total, 'class'=>'green' ],
                [ 'title' => '总手续费', 'value' => $fee, 'class'=>'blue' ]
            ],
            'tbody' => [
                ['昨日交易量 '.$yesterday_total, '昨日手续费 '.$yesterday_fee, '今日交易量 '.$today_total, '今日手续费 '.$today_fee],
            ]
        ];
        $data = ['user'=>$user, 'currency'=>$currency];
        cache($key, json_encode($data), 60*10); // 缓存10分钟
        return self::json(0, $data);
    }

    public function clearCache()
    {
        $agent_id = $this->getAgentId();
        $key = $this->getHomeCacheKey($agent_id);
        cache($key, NULL);
        return self::json(0, '', '操作成功');
    }
}



























