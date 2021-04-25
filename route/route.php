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
 	'Login/login' => ['admin/login/login', ['method' => 'post']],
    'Login/test' => ['admin/login/test', ['method' => 'get']],

    'User/list' => ['admin/user/getList', ['method' => 'get']],
    'User/isLock' => ['admin/user/isLock', ['method' => 'post']],
    'User/userDelete' => ['admin/user/userDelete', ['method' => 'post']],
    'User/userEdit' => ['admin/user/userEdit', ['method' => 'post']],
    'User/getWalletList' => ['admin/user/getWalletList', ['method' => 'get']],
    'User/walletDelete' => ['admin/user/walletDelete', ['method' => 'post']],
    'User/walletEdit' => ['admin/user/walletEdit', ['method' => 'post']],
    'User/getIdCradList' => ['admin/user/getIdCradList', ['method' => 'get']],
    'User/delIdCard' => ['admin/user/delIdCard', ['method' => 'post']],
    'User/isAuth' => ['admin/user/isAuth', ['method' => 'post']],
    'User/excel' => ['admin/user/excel', ['method' => 'get']],

    'User/getUserOrderList' => ['admin/user/getUserOrderList', ['method' => 'get']],
    'User/getCurrency' => ['admin/user/getCurrency', ['method' => 'get']],
    'User/editCurrency' => ['admin/user/editCurrency', ['method' => 'post']],

    'User/addSetting' => ['admin/user/addSetting', ['method' => 'post']],
    'User/getSetting' => ['admin/user/getSetting', ['method' => 'get']],
    'User/editSetting' => ['admin/user/editSetting', ['method' => 'post']],

    'User/getUserRechargeList' => ['admin/user/getUserRechargeList', ['method' => 'get']],
    'User/ensureRecharge' => ['admin/user/ensureRecharge', ['method' => 'post']],
    'User/editRecharge' => ['admin/user/editRecharge', ['method' => 'post']],
    'User/delRecharge' => ['admin/user/delRecharge', ['method' => 'post']],



    'User/getTakeList' => ['admin/user/getTakeList', ['method' => 'get']],
    'User/editTakeList' => ['admin/user/editTakeList', ['method' => 'post']],
    'User/getNowList' => ['admin/user/getNowList', ['method' => 'get']],
    'User/getContractOrderDetail' => ['admin/user/getContractOrderDetail', ['method' => 'get']],


    'Admin/addAccount' => ['admin/Admin/addAccount', ['method' => 'post']],
    'Admin/getList' => ['admin/Admin/getList', ['method' => 'get']],
    'Admin/editAccount' => ['admin/Admin/editAccount', ['method' => 'post']],

    'Info/logout' => ['admin/info/logout', ['method' => 'post']],
    'Info/getInfo' => ['admin/info/info', ['method' => 'get']],
    'Info/saveInfo' => ['admin/info/save', ['method' => 'post']],

    'system/save' => ['admin/params/save', ['method' => 'post']],
    'system/getSms' => ['admin/params/getSms', ['method' => 'get']],
    'system/getFh' => ['admin/params/getFh', ['method' => 'get']],
    'system/getRate' => ['admin/params/getRate', ['method' => 'get']],
    'system/getInfo' => ['admin/params/getInfo', ['method' => 'get']],
    'system/getEmail' => ['admin/params/getEmail', ['method' => 'get']],


    'agent/getDealLines' => ['admin/agent/getDealLines', ['method' => 'get']],
    'agent/getAssetList' => ['admin/agent/getAssetList', ['method' => 'get']],
    'agent/getAgentTakeList' => ['admin/agent/getAgentTakeList', ['method' => 'get']],
    'agent/getAssetReport' => ['admin/agent/getAssetReport', ['method' => 'get']],

    'agent/delAgentTake' => ['admin/agent/isAuth', ['method' => 'post']],
    'agent/isAuth' => ['admin/agent/isAuth', ['method' => 'post']],

    'agent/calcelAgentTake' => ['admin/agent/calcelAgentTake', ['method' => 'post']],
    'agent/addAgentTake' => ['admin/agent/addAgentTake', ['method' => 'post']],

    'agent/home' => ['admin/agent/home', ['method' => 'get']],
    'agent/clearCache' => ['admin/agent/clearCache', ['method' => 'post']],

    'Unlock/getType' => ['admin/unlock/getType', ['method' => 'get']],
    'Unlock/getUnlock' => ['admin/unlock/getUnlock', ['method' => 'get']],
    'Unlock/saveUnlock' => ['admin/unlock/saveUnlock', ['method' => 'post']],
    'Unlock/delUnlock' => ['admin/unlock/delUnlock', ['method' => 'post']],

    'Text/getText' => ['admin/Text/getText', ['method' => 'get']],
    'Text/saveText' => ['admin/Text/saveText', ['method' => 'post']],
    'Text/delText' => ['admin/Text/delText', ['method' => 'post']],

    '__miss__'=>'index/index/miss'
];
