<?php
namespace app\index\controller;


class Deal extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    private $buy10 = 1;
    private $sell10 = 39;

    public function createOrder()
    {
        $deal_type = intval(input('deal_type'));  // 1 币币交易  2杠杆交易
        if ($deal_type === 1) {
            return $this->bbOrder();
        }
        if ($deal_type === 2) {
            return $this->hyOrder();
        }
    }

    // 合约交易
    private function hyOrder()
    {
        /**
         * multiple: 100
         * price: 0.3168
         * amount:
         * password:
         * price_type: 0
         * mark: 1
         * currency: ETC
         * deal_type: 2
         */
        $multiple = intval(input('multiple')); // 倍数
        $price = floatval(input('price')); // 价格
        $amount = intval(input('amount')); // 手数
        $password = input('password'); // 密码

        $price_type = input('price_type'); // // 0 限价交易  1市价交易
        $mark = intval(input('mark')); //  1买入 2卖出
        $currency = input('currency'); //币种

        $uid = self::get_uid();
        if (empty($multiple) || ($price_type == 0 && empty($price)) || empty($amount) || !in_array($price_type, [0, 1]) || !in_array($mark, [1, 2]) || empty($currency)) {
            return self::json(1, '', '参数错误', request()->param());
        }
        if ($amount < 0) {
            return self::json(1, '', '数量不能小于0');
        }
//        $transaction_password = db('user')->where(['id' => $uid])->value('transaction_password');
//        if (empty($transaction_password)) {
//            return self::json(0, null, '您还未设置交易密码');
//        }
//        if (md5($password) != $transaction_password) {
//            return self::json(0, null, '交易密码错误');
//        }
        if ($mark === 1) {
            // 买入
            return $this->hyBuy($uid, $multiple, $price, $amount, $price_type, $mark, $currency);
        } else {
            // 卖出
            return $this->hySell($uid, $multiple, $price, $amount, $price_type, $mark, $currency);
        }

    }

    // 获取币种的交易手续费
    private function get_deal_rate($type, $currency, $value)
    {
        return db('currency')->where(['type' => $type, 'name' => $currency])->value($value);
    }
    private function get_params_rate($key)
    {
        return db('params')->where(['id' => 1])->value($key);
    }

    private function hyBuy($uid, $multiple, $price, $amount, $price_type, $mark, $currency)
    {
        $deal_type = 2;
        try {
            db()->startTrans();
            $wallet_id = db('user_wallet')->where(['user_id' => $uid, 'currency' => $currency,'type'=>$deal_type])->limit(0,1)->value('id');

            $balance = self::get_user_felid_value($uid, 'hy_usdt');
            $balance_lock = self::get_user_felid_value($uid, 'hy_usdt_lock');
            $deal_rate = $this->get_params_rate('c_open_rate'); //开仓手续费
            $lot = $this->get_deal_rate($deal_type, $currency, 'lot'); // 一手等于多少币种
            if ($price_type == 1) {
                // 市价买 取买10
                // 卖10---卖1 --- 买1-- 买10
                // 1
                $price = $this->get_currency_jy_value($currency, $deal_type, 1);
            }
            $total = $price * $amount * $lot;

            // 保证金
            $margin = round($total / $multiple, 8);

            if ($balance < $margin) {
                return self::json(1, '', '余额不足');
            }
            $fee = round($total * $deal_rate / 100 , 8);
            $all = round($margin + $fee, 8);

            $did = db('user_deal')->insertGetId([
                'user_id' => $uid,
                'wallet_id' => $wallet_id,
                'currency' => $currency,
                'deal_type' => $deal_type,
                'price_type' => $price_type,
                'mark' => $mark,
                'amount' => $amount * $lot,
                'remain' => $amount * $lot,
                'price' => $price,
                'time' => self::getDate(),
                'timestamp' => self::today_time_stamp(),
                'status' => 0,
                'total' => $total,
                'fee' => $fee,
                'multiple' => $multiple,
            ]);

            //db('user')->where(['id' => $uid])->setInc('hy_usdt_lock', $all);
            //db('user')->where(['id' => $uid])->setDec('hy_usdt', $all);

            db('user')->where(['id' => $uid])->update([
                'hy_usdt' => round($balance - $all, 8),
                'hy_usdt_lock' => round($balance_lock - 0 + $all, 8),
            ]);
            self::s_w_l($uid, $did, $margin, '合约交易买入扣除保证金', 7, $balance);
            self::s_w_l($uid, $did, $fee, '合约交易买入扣除手续费', 8, $balance);
            db()->commit();
            return self::json(0, '', '买入成功',$all);
        } catch (Exception $e) {
            db()->rollback();
            return self::json(1, '', '操作失败');
        }
    }

    private function hySell($uid, $multiple, $price, $amount, $price_type, $mark, $currency)
    {
        $deal_type = 2;
        try {
            db()->startTrans();
            $wallet_id = db('user_wallet')->where(['user_id' => $uid, 'currency' => $currency,'type'=>$deal_type])->limit(0,1)->value('id');
            $balance = self::get_user_felid_value($uid, 'hy_usdt');

            $balance_lock = self::get_user_felid_value($uid, 'hy_usdt_lock');

            $deal_rate = $this->get_params_rate('c_open_rate'); //开仓手续费

            $lot = $this->get_deal_rate($deal_type, $currency, 'lot'); // 一手等于多少币种
            if ($price_type == 1) {
                // 市价买 取买10
                // 卖10---卖1 --- 买1-- 买10
                // 1
                $price = $this->get_currency_jy_value($currency, $deal_type, 39);
            }
            $total = $price * $amount * $lot;
            // 保证金
            $margin = round($total / $multiple, 8);
            if ($balance < $margin) {
                return self::json(1, '', '余额不足');
            }
            $fee = round($total * $deal_rate / 100 ,8);
            $all = round($margin + $fee,8);

            $did = db('user_deal')->insertGetId([
                'user_id' => $uid,
                'wallet_id' => $wallet_id,
                'currency' => $currency,
                'deal_type' => $deal_type,
                'price_type' => $price_type,
                'mark' => $mark,
                'amount' => $amount * $lot,
                'remain' => $amount * $lot,
                'price' => $price,
                'time' => self::getDate(),
                'timestamp' => self::today_time_stamp(),
                'status' => 0,
                'total' => $total,
                'fee' => $fee,
                'multiple' => $multiple,
            ]);

            db('user')->where(['id' => $uid])->update([
                'hy_usdt' => $balance - $all,
                'hy_usdt_lock' => $balance_lock + $all,
            ]);

            self::s_w_l($uid, $did, $margin, '合约交易卖出扣除保证金', 9, $balance);
            self::s_w_l($uid, $did, $fee, '合约交易卖出扣除手续费', 10, $balance);
            db()->commit();
            return self::json(0, '', '卖出成功');
        } catch (Exception $e) {
            db()->rollback();
            return self::json(1, '', '操作失败');
        }
    }









    /*---------------------------------------------------------------------------*/
    // 币币交易
    private function bbOrder()
    {
        // price: 212.6600
        // amount: 0
        // paddword:
        // price_type: 0
        // mark: 1
        // currency: ETH
        // deal_type: 1
        $price = floatval(input('price')); // 价格
        $amount = floatval(input('amount')); //数量
        $password = input('password');  // 密码
        $price_type = intval(input('price_type')); // 0 限价交易  1市价交易
        $mark = intval(input('mark'));  //  1买入 2卖出
        $currency = input('currency');   // 币种
        $deal_type = input('deal_type');  // 1 币币交易  2杠杆交易

        if (($price_type == 1 && empty($price)) || empty($amount) || !in_array($price_type, [0, 1]) || !in_array($mark, [1, 2]) || !in_array($deal_type, [1, 2])) {
            $res = [$price, $amount, $password, $price_type, $mark, $deal_type];
            return self::json(1, $res, '参数错误');
        }
        if ($amount < 0) {
            return self::json(1, '', '数量不能小于0');
        }
        $uid = self::get_uid();
//        $transaction_password = db('user')->where(['id' => $uid])->value('transaction_password');
//        if (empty($transaction_password)) {
//            return self::json(0, null, '您还未设置交易密码');
//        }
//        if (md5($password) != $transaction_password) {
//            return self::json(0, null, '交易密码错误');
//        }
        if ($mark === 1) {
            // 买入
            return $this->buy($uid, $currency, $amount, $price, $price_type, $deal_type, $mark);
        } else {
            // 卖出
            return $this->sell($uid, $currency, $amount, $price, $price_type, $deal_type, $mark);
        }
    }


    private function buy($uid, $currency, $amount, $price, $price_type, $deal_type, $mark)
    {
        try {
            db()->startTrans();
            $wallet = self::getWallet(['user_id' => $uid, 'currency' => $currency, 'type' => $deal_type]);

            $balance = self::get_user_felid_value($uid, 'bb_usdt');
            $balance_lock = self::get_user_felid_value($uid, 'bb_usdt_lock');

            if ($price_type === 0) {
                // 限价
                $total = $price * $amount;
            } else {
                // 市价买 取买10
                // 卖10---卖1 --- 买1-- 买10
                // 1
                $price = $this->get_currency_jy_value($currency, $deal_type, 1);
                $total = $price * $amount;
            }
            $total = round($total, 8);

            $rate = $this->get_deal_rate(1, $currency, 'deal_rate');

            $sm = round($rate / 100 * $total, 8);

            $all = round($total + $sm, 8);

            if ($balance < $sm + $total) {
                return self::json(1, '', '余额不足');
            }

            $did = db('user_deal')->insertGetId([
                'user_id' => $uid,
                'currency' => $currency,
                'deal_type' => $deal_type,
                'price_type' => $price_type,
                'mark' => $mark,
                'amount' => $amount,
                'remain' => $amount,
                'price' => $price,
                'time' => self::getDate(),
                'timestamp' => self::today_time_stamp(),
                'status' => 0,
                'total' => $total,
                'fee' => $sm,
                'wallet_id' => $wallet['id']
            ]);
            db('user')->where(['id' => $uid])->update([
                'bb_usdt' => $balance - $all,
                'bb_usdt_lock' => $balance_lock + $all,
            ]);
            self::s_w_l($uid, $did, $total, '买入扣除余额', 5, $balance);
            self::s_w_l($uid, $did, $sm, '买入扣除手续费', 6, $balance);
            db()->commit();
            return self::json(0, '', '买入成功');
        } catch (Exception $e) {
            db()->rollback();
            return self::json(1, '', '操作失败');
        }
    }

    private function sell($uid, $currency, $amount, $price, $price_type, $deal_type, $mark)
    {
        try {
            db()->startTrans();
            $wallet = self::getWallet(['user_id' => $uid, 'currency' => $currency, 'type' => $deal_type]);
            $positions = $wallet['positions'];
            $positions_lock = $wallet['positions_lock'];
            if ($price_type === 0) {
                // 限价
            } else {
                // 市价买 取买10
                // 卖10---卖1 --- 买1-- 买10
                // 1
                $price = $this->get_currency_jy_value($currency, $deal_type,39);
            }
            if ($amount > $positions) {
                return self::json(1, '', '持仓不足');
            }

            $did = db('user_deal')->insertGetId([
                'user_id' => $uid,
                'currency' => $currency,
                'deal_type' => $deal_type,
                'price_type' => $price_type,
                'mark' => $mark,
                'amount' => $amount,
                'remain' => $amount,
                'price' => $price,
                'time' => self::getDate(),
                'timestamp' => self::today_time_stamp(),
                'status' => 0,
                'total' => 0,
                'fee' => 0,
                'wallet_id' => $wallet['id']
            ]);
            db('user_wallet')->where(['id' => $wallet['id']])->update([
                'positions' => $positions - $amount,
                'positions_lock' => $positions_lock + $amount
            ]);
            self::s_w_l($uid, $did, $amount, '卖出扣除', 7, $positions);

            db()->commit();
            return self::json(0, '', '卖出成功');
        } catch (Exception $e) {
            db()->rollback();
            return self::json(1, '', '操作失败');
        }
    }


    // 获取委托记录
    public function getWeiTuo()
    {
        $uid = self::get_uid();
        $currency = input('currency');
        $mark = intval(input('mark'));
        $wt = intval(input('wt')); // 0今日委托  1历史委托
        $type = intval(input('type', 1));
        $page = intval(input('page', 1));
        $limit = intval(input('limit', 5));
        $condition = [
            'user_id' => $uid,
            //  'currency' => $currency,
            'mark' => $mark,
            'deal_type' => $type
        ];
        if ($wt === 0) {
            $condition['timestamp'] = self::today_time_stamp();
        }
        if($type == 2){
            $condition['status'] = 0;
        }
        $total = db('user_deal')->where($condition)->count();
        // dump($condition);
        $list = db('user_deal')->where($condition)->order('id desc')->limit(($page - 1) * $limit, $limit)->select();
        return self::json(0, ['total' => $total, 'list' => $list]);
    }

    // 获取用户持仓记录
    public function getPositionList()
    {
        $uid = self::get_uid();
        if(empty($uid))return self::json(0, []);
        $page = intval(input('page'));
        $limit = intval(input('limit', 10));
        $currency = input('currency');
        $is_pl = intval(input('is_pl_r')); //  是否计算总盈亏和风险率

        $p_s = input('p_s'); // 0 交易中  1平仓中
        $data = [];
        $data['all_profit_loss'] = 0;
        if($is_pl == 1){
            // 总盈亏
            // $data['all_profit_loss'] = $this->get_user_hy_profit_loss($uid);
            // 风险率
            $data['hazard_rate'] = $this->get_user_hazard_rate($uid);
        }

        $sql = "select a.* , func_split(b.`value`, ',', 2) as new_price
                from jyxt_user_deal_lines_c_h a
                LEFT JOIN jyxt_currency_jy b on b.type = 2 and b.currency = a.currency
                where a.user_id = $uid and a.type in (1,2) and position > 0";

        if($page>0){
            $first = ($page - 1) * $limit;
            $sql .= " order by id desc limit $first, $limit ";
        }else{
            $sql .= " order by id desc";
        }

        $list = db()->query($sql);
        foreach ($list as $index=>$item){
            // 单笔持仓盈亏
            if($item['margin'] == 0) $list[$index]['hazard_rate'] = 0;
            else{
                $pl = $item['floating_pl']; // 合约账户总亏损

                $list[$index]['hazard_rate'] = round(($pl) / $item['margin'] * 100, 4) .'%';
            }
            //1 买入做多2 卖出做空3 卖出平多4 买入平空
            $lot = $this->get_deal_rate(2, $item['currency'], 'lot');
            $position = $item['position'] / $lot;

            $list[$index]['type_text'] = $item['currency']. ['买入做多', '卖出做空', '卖出平多', '买入平空'][$item['type'] - 1].'x'.round($position, 0);
            $value = $this->close_position_value($item['id']);
            if($item['position'] == $value){
                $list[$index]['p_s'] = 1;
            }else if($item['position'] < $value){
                unset($list[$index]);
            }else{
                $list[$index]['p_s'] = 0;
            }
            $list[$index]['lot'] = $lot;
            $list[$index]['price'] = $item['new_price'];
            $list[$index]['fee'] = $item['open_fee'];
            $list[$index]['profit_loss'] = empty($item['floating_pl']) ? 0 : $item['floating_pl'];

            $data['all_profit_loss'] += $list[$index]['profit_loss'];
        }
        $data['list'] = $list;

        return self::json(0, $data);
    }
    // 获取用户平仓记录
    public function getClosePositionList()
    {
        $uid = self::get_uid();
        $page = intval(input('page'));
        $limit = intval(input('limit', 10));
        $currency = input('currency');

        $sql = "select * from jyxt_user_deal_lines_c_h where user_id = $uid and type in (3,4)";
        if($page>0){
            $first = ($page - 1) * $limit;
            $sql .= " order by id desc limit $first, $limit ";
        }else{
            $sql .= " order by id desc";
        }
        $list = db()->query($sql);
        foreach ($list as $index => $item){
            $list[$index]['type_text'] = $item['currency'].['买入做多', '卖出做空', '卖出平多', '买入平空'][$item['type'] - 1];
            $lot = $this->get_deal_rate(2, $item['currency'], 'lot');

            $position = $item['close_out'] / $lot;
            $list[$index]['lot_num'] = round($position, 4);

            $list[$index]['fee'] = $item['close_out_fee'];
        }

        $data['list'] = $list;
        return self::json(0, $data);
    }
    // 交易撤单
    public function orderCancel()
    {
        $id = intval(input('id'));
        $deal = db('user_deal')->where(['id'=>$id])->find();
        if($deal['status'] === 2){
            return self::json(1, '', '已撤单');
        }
        if($deal['status'] === 1){
            return self::json(1, '', '该订单已完成');
        }
        $mark = $deal['mark'];
        $deal_type = $deal['deal_type'];

        $uid = self::get_uid();
        /**
         * bb_usdt
        bb_usdt_lock
        hy_usdt
        hy_usdt_lock
         */
        if($mark == 2 && $deal_type ==1){
            //币币交易 卖出撤单
            $remain = $deal['remain'];
            db('user_wallet')->where(['id'=>$deal['wallet_id']])->setInc('positions', $remain);
            db('user_wallet')->where(['id'=>$deal['wallet_id']])->setDec('positions_lock', $remain);
        }else{
            $currency = $deal['currency'];
            $remain = $deal['remain'];
            $price = $deal['price'];

            if($deal_type ==1){
                $rate = db('currency')->where(['name'=>$currency,'type'=>$deal_type])->value('deal_rate');
                $total = round($remain * $price,8);
                $fee = round($total * $rate / 100,8);

            }else{
                $rate = $this->get_params_rate('c_open_rate'); //开仓手续费
                $total = round($remain * $price / $deal['multiple'],8);
                $fee = round($total * $rate / 100,8);
            }

            if($deal_type == 1){
                $ikey = 'bb_usdt';
                $dkey = 'bb_usdt_lock';
            }else{
                $ikey = 'hy_usdt';
                $dkey = 'hy_usdt_lock';
            }
            $all =  round($total + $fee, 8);
            db('user')->where(['id'=>$uid])->setInc($ikey, $all);
            db('user')->where(['id'=>$uid])->setDec($dkey, $all);
        }
        db('user_deal')->where(['id'=>$id])->update(['status'=>2,'cancel_time'=>self::today_time_stamp(),'remain'=>0]);
        return self::json(0, '', '已撤单');
    }

    // 计算平仓剩余值
    private function close_position_value($id)
    {
        return db('user_deal')->where(['wallet_id'=>$id, 'status'=>0])->sum('remain');
    }

//    private function close_position($condition)
//    {
//        $lines = db('user_deal_lines_c_h')->where($condition)->select();
//        foreach ($lines as $item){
//            $position = $item['position'];
//            $price = $this->get_currency_jy_value($item['currency'], 2, $item['type'] == 1 ? 23 : 19);
//            $total = $position * $price / $item['multiple'];
//            $fee = $total * $c_close_rate / 100;
//            db('user')->where(['id'=>$item['user_id']])->setInc('hy_usdt', $total - $fee);
//            self::s_w_l($item['user_id'], $item['id'], $total, '平仓数量', 11);
//            self::s_w_l($item['user_id'], $item['id'], $fee, '平仓手续费', 12);
//
//            db('user_deal_lines_c_h')->where(['id'=>$item['id']])->update(['position'=>0,'type'=>$item['type'] + 2]);
//        }
//    }
    private function close_position($condition)
    {
        $lines = db('user_deal_lines_c_h')->where($condition)->select();
        foreach ($lines as $item){
            if($item['type'] == '1' || $item['type']=='2'){
                $id = intval($item['id']);
                $sql = "call proc_yjpc_id($id,@status);";
                $res = db()->query($sql);
                // $res[0][0]['_status']
            }
        }
    }
    // 平仓
    public function closePosition()
    {
        $uid = self::get_uid();
        $id = intval(input('id'));
        $currency = input('currency');
        try{
            db()->startTrans();
            // $condition['type'] = ['in', '1,2'];
            if($id == -1){
                $condition['user_id'] = $uid;
//                $condition['currency'] = $currency;
            }else{
                $condition['id'] = $id;
            }
            $this->close_position($condition);
            db()->rollback();
            return self::json(0,'','操作成功');
        } catch (Exception $e) {
            db()->rollback();
            return self::json(1, '', '操作失败');
        }
    }

    public function editPosition()
    {
        $id = intval(input('id'));
        $stop_profit = input('stop_profit');
        $stop_loss = input('stop_loss');
        $ch = db('user_deal_lines_c_h')->where(['id'=>$id])->find();
        if($ch['type'] = 1 ){
            if(($stop_profit < $ch['open_price'] || $stop_loss > $ch['open_price'])){
                return self::json(1,'','止盈价需大于开仓价,止损价需小于开仓价');
            }
        }else{
            if(($stop_profit > $ch['open_price'] || $stop_loss < $ch['open_price'])){
                return self::json(1,'','止盈价需小于开仓价,止损价需大于开仓价');
            }
        }

        db('user_deal_lines_c_h')->update([
            'id'=>$id,
            'stop_profit'=>$stop_profit,
            'stop_loss'=>$stop_loss
        ]);
        return self::json(0,'','操作成功');
    }

    // 获取交易日志
    public function getDealLog()
    {
        $page = intval(input('page'));
        $limit = intval(input('limit', 10));
        $uid = self::get_uid();
        $list = db()->query("select add_time,message,money from jyxt_user_wallet_log ORDER BY id desc limit ?,?",[ ($page - 1)*$limit, $limit ]);
        return self::json(0, $list);
    }
}
