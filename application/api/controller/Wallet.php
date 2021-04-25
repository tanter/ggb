<?php
namespace app\api\controller;


class Wallet extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getList()
    {
        $data = '{"type":"ok","message":{"list":[{"id":60,"c_id":4,"lang":"hk","title":"BTC360\u6578\u5b57\u8cc7\u7522\u4ea4\u6613\u5e73\u81fa\u5546\u5bb6\u5165\u99d0\u516c\u544a","thumbnail":"https:\/\/www.beauglobal.com\/images\/zwtp.png","cover":"https:\/\/www.beauglobal.com\/images\/zwtp.png","sorts":0},{"id":59,"c_id":4,"lang":"hk","title":"\u95dc\u65bcBTC360\u6578\u5b57\u8cc7\u7522\u4ea4\u6613\u5e73\u81fa\u4e0a\u7dda\u516c\u544a","thumbnail":"https:\/\/www.beauglobal.com\/images\/zwtp.png","cover":"https:\/\/www.beauglobal.com\/images\/zwtp.png","sorts":0}],"count":2,"page":1,"limit":15}}';
        return self::j($data);
    }
    // 资产
    public function getList2()
    {
        $currency_name = input('currency_name');
        $data = '{"type":"ok","message":{"legal_wallet":{"balance":[{"id":3,"currency":3,"legal_balance":"9000.00000000","lock_legal_balance":"1000.00000000","currency_name":"USDT","currency_type":"usdt","is_legal":1,"is_lever":1,"usdt_price":1},{"id":294,"currency":18,"legal_balance":"0.00000000","lock_legal_balance":"0.00000000","currency_name":"ETH","currency_type":"eth","is_legal":1,"is_lever":1,"usdt_price":"226.26000000"},{"id":300,"currency":19,"legal_balance":"0.00000000","lock_legal_balance":"0.00000000","currency_name":"EOS","currency_type":"eth","is_legal":1,"is_lever":1,"usdt_price":"4.23300000"},{"id":307,"currency":20,"legal_balance":"0.00000000","lock_legal_balance":"0.00000000","currency_name":"LTC","currency_type":"erc20","is_legal":1,"is_lever":1,"usdt_price":"91.32000000"},{"id":316,"currency":21,"legal_balance":"0.00000000","lock_legal_balance":"0.00000000","currency_name":"BCH","currency_type":"erc20","is_legal":1,"is_lever":1,"usdt_price":"338.02000000"},{"id":370,"currency":17,"legal_balance":"0.00000000","lock_legal_balance":"0.00000000","currency_name":"BTC","currency_type":"btc","is_legal":1,"is_lever":1,"usdt_price":"11969.74000000"},{"id":389,"currency":22,"legal_balance":"0.00000000","lock_legal_balance":"0.00000000","currency_name":"XRP","currency_type":"btc","is_legal":1,"is_lever":1,"usdt_price":"0.31100000"}],"totle":10000,"CNY":""},"change_wallet":{"balance":[{"id":3,"currency":3,"change_balance":"0.00000000","lock_change_balance":"0.00000000","currency_name":"USDT","currency_type":"usdt","is_legal":1,"is_lever":1,"usdt_price":1},{"id":294,"currency":18,"change_balance":"0.00000000","lock_change_balance":"0.00000000","currency_name":"ETH","currency_type":"eth","is_legal":1,"is_lever":1,"usdt_price":"226.26000000"},{"id":300,"currency":19,"change_balance":"0.00000000","lock_change_balance":"0.00000000","currency_name":"EOS","currency_type":"eth","is_legal":1,"is_lever":1,"usdt_price":"4.23300000"},{"id":307,"currency":20,"change_balance":"0.00000000","lock_change_balance":"0.00000000","currency_name":"LTC","currency_type":"erc20","is_legal":1,"is_lever":1,"usdt_price":"91.32000000"},{"id":316,"currency":21,"change_balance":"0.00000000","lock_change_balance":"0.00000000","currency_name":"BCH","currency_type":"erc20","is_legal":1,"is_lever":1,"usdt_price":"338.02000000"},{"id":370,"currency":17,"change_balance":"5.00000000","lock_change_balance":"0.00000000","currency_name":"BTC","currency_type":"btc","is_legal":1,"is_lever":1,"usdt_price":"11969.74000000"},{"id":389,"currency":22,"change_balance":"0.00000000","lock_change_balance":"0.00000000","currency_name":"XRP","currency_type":"btc","is_legal":1,"is_lever":1,"usdt_price":"0.31100000"}],"totle":59848.7,"CNY":""},"lever_wallet":{"balance":[{"id":3,"currency":3,"lever_balance":"86761.98706922","lock_lever_balance":"0.00000000","currency_name":"USDT","currency_type":"usdt","is_legal":1,"is_lever":1,"usdt_price":1},{"id":294,"currency":18,"lever_balance":"0.00000000","lock_lever_balance":"0.00000000","currency_name":"ETH","currency_type":"eth","is_legal":1,"is_lever":1,"usdt_price":"226.26000000"},{"id":300,"currency":19,"lever_balance":"0.00000000","lock_lever_balance":"0.00000000","currency_name":"EOS","currency_type":"eth","is_legal":1,"is_lever":1,"usdt_price":"4.23300000"},{"id":307,"currency":20,"lever_balance":"0.00000000","lock_lever_balance":"0.00000000","currency_name":"LTC","currency_type":"erc20","is_legal":1,"is_lever":1,"usdt_price":"91.32000000"},{"id":316,"currency":21,"lever_balance":"0.00000000","lock_lever_balance":"0.00000000","currency_name":"BCH","currency_type":"erc20","is_legal":1,"is_lever":1,"usdt_price":"338.02000000"},{"id":370,"currency":17,"lever_balance":"0.00000000","lock_lever_balance":"0.00000000","currency_name":"BTC","currency_type":"btc","is_legal":1,"is_lever":1,"usdt_price":"11969.74000000"},{"id":389,"currency":22,"lever_balance":"0.00000000","lock_lever_balance":"0.00000000","currency_name":"XRP","currency_type":"btc","is_legal":1,"is_lever":1,"usdt_price":"0.31100000"}],"totle":86761.98706922,"CNY":""},"ExRate":6.5,"is_open_CTbi":"1"}}';
        return self::j($data);
    }
    public function detail()
    {
        $currency = input('currency'); //18买入  19卖出
        $type = input('type');  //change
        if($currency == 18)
            $data = '{"type":"ok","message":{"id":294,"currency":18,"change_balance":"0.00000000","lock_change_balance":"0.00000000","ExRate":6.5,"currency_name":"ETH","currency_type":"eth","is_legal":1,"is_lever":1,"usdt_price":"225.13000000"}}';
        else
            $data = '{"type":"ok","message":{"id":300,"currency":19,"change_balance":"0.00000000","lock_change_balance":"0.00000000","ExRate":6.5,"currency_name":"EOS","currency_type":"eth","is_legal":1,"is_lever":1,"usdt_price":"4.21010000"}}';
        return self::j($data);
    }
}
