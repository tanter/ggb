<?php
namespace app\api\controller;


class C2c extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    // 我的C2C
    public function seller_trade()
    {
        $type = input('type'); // buy 我的求购  type 我的出售
        $currency_id = input('currency_id'); // 币种ID
        $page = input('page');
        $data = '{"type":"ok","message":{"data":[],"page":1,"pages":1,"total":0}}';
        return self::j($data);
    }
    // 我的c2c 已完成订单记录
    public function c2c_seller_deal()
    {
        $currency_id = input('currency_id'); //币种ID
        $page = input('page'); // 页数
        $data = '{"type":"error","message":"\u60a8\u7684\u5b9e\u540d\u8ba4\u8bc1\u8fd8\u672a\u901a\u8fc7\uff01"}';
        return self::j($data);
    }
    // 我交易的c2c
    public function c2c_user_deal()
    {
        $currency_id = input('currency_id'); //币种ID
        $page = input('page'); // 页数
        $data = '{"type":"error","message":"\u60a8\u7684\u5b9e\u540d\u8ba4\u8bc1\u8fd8\u672a\u901a\u8fc7\uff01"}';
        return self::j($data);
    }
    public function c2c_deal_platform()
    {
        /**
         * type: sell
        page: 1
        currency_id: 18
         */
        $data = '{"type":"ok","message":{"data":[],"page":1,"pages":1,"total":0}}';
        return self::j($data);
    }
}
