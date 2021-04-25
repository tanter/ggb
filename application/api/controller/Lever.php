<?php
namespace app\api\controller;

class Lever extends Base
{
	public function __construct()
	{
		parent::__construct();
	}
    public function deal()
    {
        $legal_id = input('legal_id'); //18
        $currency_id = input('currency_id'); // 19 合约交易
        $data = '{"type":"ok","message":{"lever_transaction":{"in":[],"out":[]},"my_transaction":[],"lever_share_limit":{"min":1,"max":0},"multiple":{"muit":[{"value":"50"},{"value":"20"},{"value":"100"}],"share":[{"value":"100"}]},"last_price":"0.01867","user_lever":"0.00000000","all_levers":0,"ustd_price":0,"ExRAte":6.5}}';
        return self::j($data);
    }
    public function dealall()
    {
        /**
         * legal_id: 18
        currency_id: 19
        page: 1
        limit: 10
         */
        $data = '{"type":"ok","message":{"balance":"0.00000000","hazard_rate":0,"caution_money_total":0,"origin_caution_money_total":0,"profits_total":0,"caution_money":0,"origin_caution_money":0,"profits":0,"order":{"current_page":1,"data":[],"first_page_url":"http:\/\/jyxt.ys.13mv.com\/api\/lever\/dealall?page=1","from":null,"last_page":1,"last_page_url":"http:\/\/jyxt.ys.13mv.com\/api\/lever\/dealall?page=1","next_page_url":null,"path":"http:\/\/jyxt.ys.13mv.com\/api\/lever\/dealall","per_page":"10","prev_page_url":null,"to":null,"total":0}}}';
        return self::j($data);
    }

    public function my_trade()
    {
        /**
         * page: 1
        status: 0
        currency_id: 19
        legal_id: 18
         */
        $data = '{"type":"ok","message":{"current_page":1,"data":[],"first_page_url":"http:\/\/jyxt.ys.13mv.com\/api\/lever\/my_trade?page=1","from":null,"last_page":1,"last_page_url":"http:\/\/jyxt.ys.13mv.com\/api\/lever\/my_trade?page=1","next_page_url":null,"path":"http:\/\/jyxt.ys.13mv.com\/api\/lever\/my_trade","per_page":10,"prev_page_url":null,"to":null,"total":0}}';
        return self::j($data);
    }
}
