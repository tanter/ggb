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
    'web/test' => ['index/index/test', ['method' => 'get']],
 	'web/getTelCode' => ['index/index/getTelCode', ['method' => 'get']],
 	'web/userLogin' => ['index/index/userLogin', ['method' => 'post']],
 	'web/getCode' => ['index/index/getCode', ['method' => 'get']],
 	'web/userRegister' => ['index/index/userRegister', ['method' => 'post']],
	'web/getCurrencyPriceAndIncrease' => ['index/index/getCurrencyPriceAndIncrease', ['method' => 'get']],
    'web/getInfo' => ['index/index/getInfo', ['method' => 'get']],
    'web/getBanner' => ['index/index/getBanner', ['method' => 'get']],



	'web/info' => ['index/User/info', ['method' => 'get']],
	'web/getLevel' => ['index/User/accountSafetyLevel', ['method' => 'get']],
	'web/saveTpwd' => ['index/User/saveTpwd', ['method' => 'post']],
	'web/updatePassword' => ['index/User/updatePassword', ['method' => 'post']],
	'web/userIdCard' => ['index/User/userIdCard', ['method' => 'post']],
	'web/userIdCard' => ['index/User/userIdCard', ['method' => 'post']],
	'web/updateInfo' => ['index/user/updateInfo', ['method' => 'post']],
    'web/getSetting' => ['index/user/getSetting', ['method' => 'get']],


	'web/getCurrency' => ['index/asset/getCurrency', ['method' => 'get']],
	'web/getCurrencyType' => ['index/asset/getCurrencyType', ['method' => 'get']],
	'web/getAsset' => ['index/asset/getAsset', ['method' => 'get']],
	'web/getAddressList' => ['index/asset/getAddressList', ['method' => 'get']],
	'web/addAddress' => ['index/asset/addAddress', ['method' => 'post']],
	'web/delAddress' => ['index/asset/delAddress', ['method' => 'post']],
	'web/editAddress' => ['index/asset/editAddress', ['method' => 'post']],
	'web/getWalletLine' => ['index/asset/getWalletLine', ['method' => 'get']],
    'web/tokeMoney' => ['index/asset/tokeMoney', ['method' => 'post']],
	'web/getWalletLog' => ['index/asset/getWalletLog', ['method' => 'get']],
	'web/geTransfer' => ['index/asset/geTransfer', ['method' => 'get']],
	'web/assetTransfer' => ['index/asset/assetTransfer', ['method' => 'post']],
	'web/assetRecharge' => ['index/asset/assetRecharge', ['method' => 'post']],

	'web/createOrder' => ['index/deal/createOrder', ['method' => 'post']],
	'web/getWeiTuo' => ['index/deal/getWeiTuo', ['method' => 'get']],
	'web/orderCancel' => ['index/deal/orderCancel', ['method' => 'post']],
	'web/getDealLog' => ['index/deal/getDealLog', ['method' => 'get']],
    'web/getPositionList' => ['index/deal/getPositionList', ['method' => 'get']],
    'web/cancalPosition' => ['index/deal/cancalPosition', ['method' => 'post']],
    'web/closePosition' => ['index/deal/closePosition', ['method' => 'post']],
    'web/editPosition' => ['index/deal/editPosition', ['method' => 'post']],

    'web/getGG' => ['index/index/getGG', ['method' => 'get']],
    'web/getCutttencyInfo' => ['index/index/getCutttencyInfo', ['method' => 'get']],

    'web/uploadImg' => ['index/Upload/uploadImg', ['method' => 'post']],
    'web/idcardinfo' => ['index/User/idcardinfo', ['method' => 'get']],

    'web/getDealList' => ['index/user/getDealList', ['method' => 'get']],
    'web/getClosePositionList' => ['index/deal/getClosePositionList', ['method' => 'get']],

    'web/getText' => ['index/index/getText', ['method' => 'get']],

    'web/new_timeshar' => ['index/TradingView/new_timeshar', ['method' => 'get']],
    '__miss__'=>'index/index/miss'
];
