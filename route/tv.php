<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// Route::get('think', function () {
//     return 'hello,ThinkPHP5!';
// });

// Route::get('hello/:name', 'index/hello');

return [
 // 	'config' => ['index/TradingView/config', ['method' => 'get']],
 // 	'time' => ['index/TradingView/time', ['method' => 'get']],
	// 'symbols' => ['index/TradingView/symbols', ['method' => 'get']],

	// 'history' => ['index/TradingView/history', ['method' => 'get']],
	// 'marks' => ['index/TradingView/marks', ['method' => 'get']],
	// 'timescale_marks' => ['index/TradingView/timescale_marks', ['method' => 'get']],


	'new_timeshar' => ['index/TradingView/new_timeshar', ['method' => 'get']],
	'next_timeshar' => ['index/TradingView/next_timeshar', ['method' => 'get']],
];
