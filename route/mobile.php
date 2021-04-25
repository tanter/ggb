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

return [
    'api/wallet/list' =>  ['api/wallet/getList', ['method' => 'post']],
    'api/wallet/list2' =>  ['api/wallet/getList2', ['method' => 'post']],

    'api/wallet/detail' =>  ['api/wallet/detail', ['method' => 'post']],

    'api/news/list' => ['api/News/getList', ['method' => 'post']],
    'api/news/detail' => ['api/News/detail', ['method' => 'post']],

    'api/currency/quotation_new' => ['api/Currency/quotation_new', ['method' => 'get']],
    'api/currency/list' => ['api/Currency/getList', ['method' => 'get']],
    'walletMiddle/GetDrawAddress' => ['api/Currency/GetDrawAddress', ['method' => 'get']],
    'walletMiddle/SendVerificationcode' => ['api/Currency/SendVerificationcode', ['method' => 'get']],
    'walletMiddle/BindDrawAddress' => ['api/Currency/BindDrawAddress', ['method' => 'post']],
    'api/currency/new_timeshar'=> ['api/Currency/new_timeshar', ['method' => 'get']],

    'api/user/login' => ['api/User/login', ['method' => 'post']],
    'api/user/info' => ['api/User/info', ['method' => 'get']],
    // 下一步检测短信验证码
    'api/user/check_mobile' => ['api/User/check_mobile', ['method' => 'post']],
    // 更改密码
    'api/user/forget' => ['api/User/forget', ['method' => 'post']],
    'api/user/cash_info' => ['api/User/cash_info', ['method' => 'post']],
    'api/user/logout' => ['api/User/logout', ['method' => 'post']],


    'api/transaction_out'  => ['api/Transaction/transaction_out', ['method' => 'post']],
    'api/transaction/deal'  => ['api/Transaction/deal', ['method' => 'post']],

    'api/lever/deal'  => ['api/Lever/deal', ['method' => 'post']],

    'api/lever/dealall'  => ['api/Lever/dealall', ['method' => 'post']],

    'api/lever/my_trade'  => ['api/Lever/my_trade', ['method' => 'post']],

    'api/user/center' => ['api/User/center', ['method' => 'get']],
    'api/user/cash_save' => ['api/User/cash_save', ['method' => 'post']],

    'api/c2c/seller_trade' => ['api/C2c/seller_trade', ['method' => 'get']],
    'api/c2c_seller_deal' => ['api/C2c/c2c_seller_deal', ['method' => 'get']],
    'api/c2c_user_deal' => ['api/C2c/c2c_user_deal', ['method' => 'get']],
    'api/c2c_deal_platform' => ['api/C2c/c2c_deal_platform', ['method' => 'get']],

    'api/lang/set' => ['api/Lang/set', ['method' => 'post']],

    'api/safe/safe_center' => ['api/Safe/safe_center', ['method' => 'post']],
    'api/safe/update_password' => ['api/Safe/update_password', ['method' => 'post']],

    // 发生短信验证
    'api/sms_send' => ['api/Sms/sms_send', ['method' => 'post']],

    '__miss__'=>'index/index/miss'
];
