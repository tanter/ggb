<?php
namespace app\api\controller;

class Transaction extends Base
{
	public function __construct()
	{
		parent::__construct();
	}
	public function transaction_out(){
	    $page = input('page'); // 1

        $data = '{"type":"ok","message":{"list":[],"count":0,"page":"1","limit":10}}';
        return self::j($data);
    }

    public function deal()
    {
        $legal_id = input('legal_id'); //18
        $currency_id = input('currency_id'); // 18 币币交易
        if($currency_id == 18) $data = '{"type":"ok","message":{"in":[],"out":[],"legal_currency":{"id":18,"name":"ETH","get_address":"","sort":-901,"logo":"","is_display":1,"min_number":"0.00000000","max_number":"0.00000000","rate":"0.00","is_lever":1,"is_legal":1,"is_match":1,"show_legal":0,"type":"eth","decimal_scale":18,"chain_fee":"0.00000000","black_limt":0,"total_account":"","allow_game_exchange":0,"create_time":"1970-01-01 08:00:00"},"last_price":"0.01869","user_legal":"0.00000000","user_currency":"0.00000000","complete":[],"currency_match":{"id":94,"legal_id":18,"currency_id":19,"is_display":1,"market_from":2,"open_transaction":0,"open_lever":0,"exchange_rate":"0.00","sort":0,"lever_share_num":"1.00000000","spread":"0.0000","overnight":"0.0000","lever_trade_fee":"0.0000","lever_min_share":1,"lever_max_share":0,"create_time":"2019-08-05 16:50:37","legal_name":"ETH","currency_name":"EOS","market_from_name":"\u706b\u5e01\u63a5\u53e3","change":"+0.45","volume":"243221.06288","now_price":"0.01869"}}}';
        else $data = '{"type":"ok","message":{"in":[],"out":[],"legal_currency":{"id":3,"name":"USDT","get_address":"","sort":-2,"logo":"http:\/\/lever.mobile369.com\/upload\/1543391412778489.png","is_display":1,"min_number":"200.00000000","max_number":"1000.00000000","rate":"0.05","is_lever":1,"is_legal":1,"is_match":1,"show_legal":1,"type":"usdt","decimal_scale":8,"chain_fee":"0.00006000","black_limt":0,"total_account":"1FxQSphr4iqJfAJpPjAAcGhBGyMi5aiHcv","allow_game_exchange":1,"create_time":"1970-01-01 08:00:00"},"last_price":"11893.69000","user_legal":"0.00000000","user_currency":"5.00000000","complete":[],"currency_match":{"id":2,"legal_id":3,"currency_id":17,"is_display":1,"market_from":2,"open_transaction":1,"open_lever":1,"exchange_rate":"0.20","sort":-1000,"lever_share_num":"0.02000000","spread":"0.3000","overnight":"0.2000","lever_trade_fee":"0.1600","lever_min_share":1,"lever_max_share":50000,"create_time":"2019-08-02 19:06:39","legal_name":"USDT","currency_name":"BTC","market_from_name":"\u706b\u5e01\u63a5\u53e3","change":"+1.93","volume":"22208.61247","now_price":"11893.69000"}}}';
        return self::j($data);
    }
}
