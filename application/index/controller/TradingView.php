<?php
namespace app\index\controller;


class TradingView extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    // public function config()
    // {
    // 	$data = '{"supports_search":false,"supports_group_request":false,"supports_marks":true,"supports_timescale_marks":true,"supports_time":true,"exchanges":["gh"],"symbols_types":[],"supported_resolutions":["1", "3", "5", "15", "30", "60", "120", "240", "360", "720", "1D", "3D", "1W", "1M"]}';
    // 	$data = json_decode($data, true);
    // 	return json($data);
    // }
    // public function time()
    // {
    // 	$time = time();
    // 	return json($time);
    // }
    // public function symbols()
    // {
    // 	$symbol = input('symbol');

    // 	$data = '{"name":"AAPL","exchange-traded":"NasdaqNM","exchange-listed":"NasdaqNM","timezone":"America/New_York","minmov":1,"minmov2":0,"pointvalue":1,"session":"0930-1630","has_intraday":false,"has_no_volume":false,"description":"Apple Inc.","type":"stock","supported_resolutions":["D","2D","3D","W","3W","M","6M"],"pricescale":100,"ticker":"AAPL"}';

    // 	$data = json_decode($data, true);
    // 	return json($data);
    // }
    // public function history()
    // {
    // 	$symbol = input('symbol');
    // 	$resolution = input('resolution');
    // 	$from = input('from');
    // 	$to = input('to');
    // 	// {"s":"no_data","nextTime":1522108800}

    // 	$data = '{"t":[1519603200,1519689600,1519776000,1519862400,1519948800,1520208000,1520294400,1520380800,1520467200,1520553600,1520812800,1520899200,1520985600,1521072000,1521158400,1521417600,1521504000,1521590400,1521676800,1521763200,1522022400,1522108800],"o":[176.35,179.1,179.26,178.54,172.8,175.21,177.91,174.94,175.48,177.96,180.29,182.59,180.32,178.5,178.65,177.32,175.24,175.04,170,168.39,168.07,173.68],"h":[179.39,180.48,180.615,179.775,176.3,177.74,178.25,175.85,177.12,180,182.39,183.5,180.52,180.24,179.12,177.47,176.8,175.09,172.68,169.92,173.1,175.15],"l":[176.21,178.16,178.05,172.66,172.45,174.52,176.13,174.27,175.07,177.39,180.21,179.24,177.81,178.0701,177.62,173.66,174.94,171.26,168.6,164.94,166.44,166.92],"c":[178.97,178.39,178.12,175,176.21,176.82,176.67,175.03,176.94,179.98,181.72,179.97,178.44,178.65,178.02,175.3,175.24,171.27,168.845,164.94,172.77,168.34],"v":[36886432,38685165,33604574,48801970,38453950,28401366,23788506,31703462,23163767,31385134,32055405,31168404,29075469,22584565,36836456,32804695,19314039,35247358,41051076,40248954,36272617,38962839],"s":"ok"}';
    // 	$data = json_decode($data, true);
    // 	return json($data);
    // }
    // public function marks()
    // {
    // 	$symbol = input('symbol');
    // 	$resolution = input('resolution');
    // 	$from = input('from');
    // 	$to = input('to');

    // 	$data = '{"id":[0,1,2,3,4,5],"time":[1564531200,1564185600,1563926400,1563926400,1563235200,1561939200],"color":["red","blue","green","red","blue","green"],"text":["Today","4 days back","7 days back + Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.","7 days back once again","15 days back","30 days back"],"label":["A","B","CORE","D","EURO","F"],"labelFontColor":["white","white","red","#FFFFFF","white","#000"],"minSize":[14,28,7,40,7,14]}';
    // 	$data = json_decode($data, true);
    // 	return json($data);
    // }
    // public function timescale_marks()
    // {
    // 	$symbol = input('symbol');
    // 	$resolution = input('resolution');
    // 	$from = input('from');
    // 	$to = input('to');

    // 	$data = '[{"id":"tsm1","time":1564531200,"color":"red","label":"A","tooltip":""},{"id":"tsm2","time":1564185600,"color":"blue","label":"D","tooltip":["Dividends: $0.56","Date: Sat Jul 27 2019"]},{"id":"tsm3","time":1563926400,"color":"green","label":"D","tooltip":["Dividends: $3.46","Date: Wed Jul 24 2019"]},{"id":"tsm4","time":1563235200,"color":"#999999","label":"E","tooltip":["Earnings: $3.44","Estimate: $3.60"]},{"id":"tsm7","time":1561939200,"color":"red","label":"E","tooltip":["Earnings: $5.40","Estimate: $5.00"]}]';

    // 	$data = json_decode($data, true);
    // 	return json($data);
    // }
    private function getPeroid($key)
    {
        $p = [
            '1min'   => '1m',
            '5min'   => '5m',
            '15min'  => '15m',
            '30min'  => '30m',
            '1hour'  => '1h',
            '1day'   => '1d',
            '1week'  => '1w',
        ];
        return isset($p[$key]) ? $p[$key] : '1m';
    }
    public function new_timeshar()
    {
        $symbol = input('symbol');
        $period = strtolower(input('period'));
        $size = 200;
		
      // 1day, 1mon, 1week
      	
      	if($period=='1d') $period = '1day';
      	if($period=='1w') $period = '1week';
      
        $hb = new Huobi();
        $data = $hb->get_history_kline($symbol, $period,$size);
        return json($data);
    }

    public function next_timeshar()
    {
        $period = $this->getPeroid(input('period')); // '1m';
        $symbol = input('symbol');
        $basecurrency =  explode('/',$symbol)[0]; // 'BTC';
        $type = intval(input('type')); // 1币币交易  2合约交易
        $limit = 1;
        $sql = 'select * from jyxt_currency_k_line where basecurrency = ? and  period = ? and type = ? order by time desc limit ?';
        $bind = [$basecurrency, $period, $type, $limit];
        $data = tv()->query($sql,$bind);
        if(empty($data)) return json(null);
        //$str = '{"id":1565269800,"period":"1min","base-currency":"EOS","quote-currency":"ETH","open":0.01863065,"close":0.01863065,"high":0.01863065,"low":0.01863065,"vol":0.374476065,"amount":20.1,"time":1565269800000,"volume":20.1}';
        //$data = json_decode($str, true);
        $res = $data[0];
        $res['time'] = $res['time'] * 1000;
        return json($res);
    }
}
