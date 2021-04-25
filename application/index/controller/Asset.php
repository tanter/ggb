<?php

namespace app\index\controller;


class Asset extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    private function get_currency_type()
    {
        $lang = input('lang', 'zh');
        if($lang=='zh')$lang = 'value';

        $type = db('currency_type')->select();
        $data = [];
        foreach ($type as $index=>$item){
            $data[] = [
                'id' => $item['id'],
                'value'=>$item[$lang]
            ];
        }
        return $data;
    }
    // 获取账户类型
    public function getCurrencyType()
    {
        return self::json(0, $this->get_currency_type());
    }

    public function getCurrency()
    {
        $id = intval(input('id'));
        $data = db('currency')->where(['type' => $id, 'status' => 0])->field('id, name,symbol')->select();
        return self::json(0, $data);
    }

    // 获取币币账户资产
    private function getAsset_bb()
    {
        $type = 1;
        $uid = self::get_uid();
        $sql = "select a.*,b.address
                    from jyxt_user_wallet a, jyxt_currency b
                    where a.user_id = $uid
                    and b.name = a.currency
                    and b.`status` = 0
                    and b.type = $type";
        $currency = db()->query($sql);
        $bb_usdt = self::get_user_felid_value($uid, 'bb_usdt');
        $bb_usdt_lock = self::get_user_felid_value($uid, 'bb_usdt_lock');
        $totalMoney = $bb_usdt + $bb_usdt_lock;
        $zh = 0;
        foreach ($currency as $index => $item) {
            // 计算折合价
            $price = $this->get_currency_jy_value($item['currency'], $type, 2, 'value');
            $currency[$index]['zh'] = round(($item['positions'] + $item['positions_lock']) * $price, 8);
            $zh += $currency[$index]['zh'];
        }
        $totalMoney += $zh;

        $currency[] = [
            'transfer' => true,
            'currency' => 'USDT',
            'address' => db('currency')->where(['name'=>'USDT'])->value('address'),
            'positions' => $bb_usdt,
            'positions_lock' => $bb_usdt_lock,
            'zh' => round($totalMoney, 8)
        ];

        // 总资产等于总金额+冻结金额+所有币种的折合金额
        return self::json(0, ['list' => $currency, 'totalMoney' => $totalMoney, 'moneyUnit' => 'USDT']);
    }

    // 获取币币账户资产
    private function getAsset_hy()
    {
        $type = 2;
        $uid = self::get_uid();
        $hy_usdt = self::get_user_felid_value($uid, 'hy_usdt');
        $hy_usdt_lock = self::get_user_felid_value($uid, 'hy_usdt_lock');
        $totalMoney = $hy_usdt + $hy_usdt_lock;
        // 合约折合
        $zh = $this->get_user_hy_total_zh($uid);
        $totalMoney += $zh;

        $currency[] = [
            'transfer' => true,
            'currency' => 'USDT',
            'address' => db('currency')->where(['name'=>'USDT'])->value('address'),
            'positions' => $hy_usdt,
            'positions_lock' => $hy_usdt_lock,
            'zh' => round($totalMoney, 8)
        ];
        return self::json(0, ['list' => $currency, 'totalMoney' => $totalMoney, 'moneyUnit' => 'USDT']);
    }

    public function getAsset()
    {
        $id = $this->get_c_id(input('id'));
        if ($id == 1) return $this->getAsset_bb();
        if ($id == 2) return $this->getAsset_hy();
        return self::json(1, '', '请正常操作');
    }
//// 获取资产
//    public function getAsset()
//    {
//        $id   = $this->get_c_id(input('id'));
//        $uid = self::get_uid();
//        if($id==1){
//            $sql = "select a.*,b.address
//                    from jyxt_user_wallet a, jyxt_currency b
//                    where a.user_id = $uid
//                    and b.name = a.currency
//                    and b.`status` = 0
//                    and b.type = 1";
//        }else{
//            $sql = "select a.*,b.address
//                    from jyxt_user_wallet_c a, jyxt_currency b
//                    where a.user_id = $uid
//                    and b.name = a.currency
//                    and b.`status` = 0
//                    and b.type = 2";
//        }
//        $currency = db()->query($sql);
//        $balance = 0;
//        $balance_lock = 0;
//        foreach ($currency as $index => $item) {
//            if($index == 0)  {
//                $balance = $item['balance'];
//                $balance_lock = $item['balance_lock'];
//            }
//            $currency[$index]['zh'] = '0';
//
//            if($id ==2){
//                $ch = db('user_deal_lines_c_h')->where(['user_id'=>$uid,'currency'=>$item['currency']])->select();
//                $currency[$index]['positions_lock'] = 0;
//                foreach ($ch as $o){
//                    $currency[$index]['positions_lock'] += round($o['position'] / $o['multiple'], 4);
//                }
//            }
//        }
//        $currency[] = [
//            'transfer'=>true,
//            'currency'=>'USDT',
//            'positions'=>$balance,
//            'positions_lock' => $balance_lock,
//            'zh'=>'0'
//        ];
//        return self::json(0, ['list'=>$currency, 'totalMoney'=>$balance + $balance_lock, 'moneyUnit'=>'USDT']);
//    }
    private function get_c_id($id)
    {
        $id = intval($id);
        $type = db('currency_type')->where(['id' => $id])->value('id');
        if (empty($type)) {
            return 1;
        }
        return $id;
    }

    // 获取地址
    public function getAddressList()
    {
        $id = $this->get_c_id(input('id'));
        $uid = self::get_uid();
        $page = intval(input('page', 1));
        $currency = input('currency');
        $condition = ['user_id' => $uid, 'type' => $id, 'is_delete' => 0];
        if (!empty($condition)) {
            $condition['currency'] = $currency;
            $limit = 10000;
        } else {
            $limit = 10;
        }

        $data = db('user_wallet_address')->where($condition)->order('id desc')->limit(($page - 1) * $limit, $limit)->select();
        return self::json(0, $data);
    }

    public function addAddress()
    {
        $value = intval(input('value'));
        $address = input('address');
        $message = input('message');
        $type = $this->get_c_id(input('type'));
        $name = $value == -1 ? 'USDT' : db('currency')->where(['id' => $value])->value('name');
        if (empty($name) || empty($address)) {
            return self::json(1, null, '参数错误');
        }
        $uid = self::get_uid();
        $data = ['user_id' => $uid, 'type' => $type, 'currency' => $name, 'address' => $address, 'message' => $message, 'add_time' => self::getDate()];
        $wid = db('user_wallet_address')->insertGetId($data);
        $item = db('user_wallet_address')->where(['id' => $wid])->find();
        return self::json(0, $item, '添加成功');
    }

    public function delAddress()
    {
        $wid = intval(input('id'));
        db('user_wallet_address')->where(['id' => $wid])->update(['is_delete' => 1]);
        return self::json(0, '', '删除成功');
    }

    public function editAddress()
    {
        $wid = intval(input('id'));
        $value = intval(input('value'));
        $address = input('address');
        $message = input('message');
        $name = db('currency')->where(['id' => $value])->value('name');
        if (empty($wid) || empty($name) || empty($address) || empty($message)) {
            return self::json(1, null, '参数错误');
        }
        $data = ['currency' => $name, 'address' => $address, 'message' => $message, 'id' => $wid];
        db('user_wallet_address')->update($data);
        $item = db('user_wallet_address')->where(['id' => $wid])->find();
        return self::json(0, $item, '保存成功');
    }

    public function getWalletLine()
    {
        $wid = intval(input('wid'));
        $item = self::getWallet(['id' => $wid]);
        $rate = db('params')->where('id=1')->value('c_tb_rate');
        return self::json(0, ['item' => $item, 'rate' => $rate, 'money'=>$item['positions']]);
    }

    // 提币
    public function tokeMoney()
    {
        $wid = intval(input('wid'));
        $address = input('address');
        $number = floatval(input('number'));
        $password = input('password');
        $uid = self::get_uid();
        $type = $this->get_c_id(input('type'));
        if (empty($address) || empty($number) || empty($password)) {
            return self::json(1, '', '参数不能为空');
        }
        $param = db('params')->field('c_tb_money,c_tb_rate')->where('id=1')->find();
        if ($param['c_tb_money'] > $number) {
            return self::json(1, '', '最低提币额度:' . $param['c_tb_money']);
        }
        //总资产
        if(empty($wid)){
            $key = $type == 1 ? 'bb_usdt' : 'hy_usdt';
            $balance = db('user')->where(['id'=>$uid])->value($key);
            $currency = 'USDT';
        }else{
            $balance = db('user_wallet')->where(['id' => $wid])->value('positions');
            $currency = db('user_wallet')->where(['id' => $wid])->value('currency');
        }
        if (empty($balance) || $balance < $number) {
            return self::json(1, '', '余额不足');
        }
        $service_charge = $param['c_tb_rate'] / 100 * $number;

        $transaction_password = db('user')->where(['id' => $uid])->value('transaction_password');
        if (empty($transaction_password)) {
            return self::json(1, '', '您还未设置交易密码');
        }
        if ($transaction_password != md5($password)) {
            return self::json(1, '', '交易密码错误');
        }

        $uwd = db('user_wallet_take')->insertGetId([
            'user_id' => $uid,
            'currency' => $currency,
            'address' => $address,
            'money' => $number,
            'service_charge' => $service_charge,
            'status' => 0,
            'add_time' => self::getDate()
        ]);

        $lid = self::s_w_l($uid, $uwd, 0 - $number, '扣除提币数量', 1);
        self::s_w_l($uid, $lid, 0 - $service_charge, '扣除提币手续费', 2);
        if(empty($wid)){
            $key = $type == 1 ? 'bb_usdt' : 'hy_usdt';
            db('user')->where(['id'=>$uid])->setDec($key,$service_charge + $number);
        }else{
            db('user_wallet')->where(['id' => $wid])->setDec('positions', $service_charge + $number);
        }

        return self::json(0, '', '提币申请成功');
    }

    // 获取币种的记录
    public function getWalletLog()
    {
        $wid = intval(input('wid'));
        $page = input('page');
        $currency = input('currency');
        $type = input('type');
        /**
         * 1提现
        2提现扣除手续费
        3 交易币划转法币 减
        4交易币划转法币  加
        5币币交易买入扣除金额
        6币币交易买入扣除手续费
        7合约交易买入扣除保证金
        8合约交易买入买入扣除手续费
        9合约交易卖出扣除保证金
        10合约交易卖出扣除手续费
        11合约交易平仓数量
        12合约交易平仓手续费
        13合约交易隔夜费
         */

        $limit = 10;
        $condition = ['user_id' => self::get_uid()];
        if ($wid) {
            $condition['gl_id'] = $wid;
        }
        $data = db('user_wallet_log')->where($condition)->order('id desc')->limit(($page - 1) * $limit, $limit)->select();
        return self::json(0, $data);
    }

    public function geTransfer()
    {
        $type = intval(input('type'));
        //$currency = db()->query("select `name`, type, count(`name`) as count from jyxt_currency where status = 0 GROUP BY `name` order by count desc");
        $currency = [
            [
                'name' => 'USDT',
                'count' => 2
            ],
        ];
        $uid = self::get_uid();
        $data = [
            'USDT' => [
                [
                    'type' => 1,
                    'balance' => $balance = self::get_user_felid_value($uid, 'bb_usdt')
                ],
                [
                    'type' => 2,
                    'balance' => $balance = self::get_user_felid_value($uid, 'hy_usdt')
                ]
            ]
        ];
        $types = $this->get_currency_type();

        return self::json(0, ['list' => $data, 'currency' => $currency, 'types' => $types]);
    }

    // 用户充币
    public function assetRecharge()
    {
        $number = floatval(input('number'));
        $currency = input('currency');
        $type = input('type');
        $certificate_url = input('certificate_url');
        $certificate = input('certificate');

        //$address = input('address');
        $address = '';
        if ($currency == 'USDT') {
            if ($type != 2 && $type != 1) {
                return self::json(1, '', '参数错误');
            }
        } else {
            $address = db('currency')->where(['name' => $currency, 'type' => $type])->value('address');
            if (empty($number) || empty($currency) || empty($type) || empty($address)) {
                return self::json(1, '', '参数错误');
            }
        }

        $id = db('user_wallet_recharge')->insertGetId([
            'user_id' => self::get_uid(),
            'currency' => $currency,
            'type' => $type,
            'to_address' => $address,
            'money' => $number,
            'status' => 0,
            'add_time' => self::getDate(),
            'certificate_url'=>$certificate_url,
            'certificate'=>$certificate
        ]);
        if ($id) return self::json(0, '', '充币成功，等待审核');
        return self::json(1, '', '充币失败，请联系客服');
    }

    // 划转
    public function assetTransfer()
    {
        try {
            db()->startTrans();
            $number = floatval(input('number'));
            $currency = input('currency');
            $fid = intval(input('fid'));
            $tid = intval(input('tid'));
            $type = intval(input('type'));

            // 从 fid 转到 tid   1到2  或2到1   1币币 2合约
            if (empty($number) || empty($currency) || empty($fid) || empty($tid)) {
                return self::json(1, '', '参数错误');
            }
            $uid = self::get_uid();
            if ($fid == 1) {
                $fkey = 'bb_usdt';
                $tkey = 'hy_usdt';
            } else {
                $fkey = 'hy_usdt';
                $tkey = 'bb_usdt';
            }
            $balance = self::get_user_felid_value($uid, $fkey);

            if (empty($balance) || $balance < $number) {
                return self::json(1, '', '划转余额不足');
            }

            $condition['id'] = $uid;
            db('user')->where($condition)->setDec($fkey, $number);
            db('user')->where($condition)->setInc($tkey, $number);

            self::s_w_l($uid, 0, 0 - $number, '划转', 3);
            db()->commit();
            return self::json(0, '', '划转成功');
        } catch (Exception $e) {
            db()->rollback();
            return self::json(1, '', '操作失败');
        }
    }
}
