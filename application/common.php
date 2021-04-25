<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Db;

function tv(){
//    return Db::connect([
//        // 数据库类型
//        'type'        => 'mysql',
//        // 数据库连接DSN配置
//        'dsn'         => '',
//        // 服务器地址
//        'hostname'    => '172.105.228.18',
//        // 数据库名
//        'database'    => 'jyxt',
//        // 数据库用户名
//        'username'    => 'dazhiyun',
//        // 数据库密码
//        'password'    => 'dazhiyun123',
//        // 数据库连接端口
//        'hostport'    => '3306',
//        // 数据库连接参数
//        'params'      => [],
//        // 数据库编码默认采用utf8
//        'charset'     => 'utf8',
//        // 数据库表前缀
//        'prefix'      => 'jyxt_',
//    ]);
    return tv2();
}

function tv2(){
    return Db::connect([
        // 数据库类型
        'type'        => 'mysql',
        // 数据库连接DSN配置
        'dsn'         => '',
        // 服务器地址
        'hostname'    => '127.0.0.1',
        // 数据库名
        'database'    => 'jyxt',
        // 数据库用户名
        'username'    => 'root',
        // 数据库密码
        'password'    => 'Aa123123',
        // 数据库连接端口
        'hostport'    => '3306',
        // 数据库连接参数
        'params'      => [],
        // 数据库编码默认采用utf8
        'charset'     => 'utf8',
        // 数据库表前缀
        'prefix'      => 'jyxt_',
    ]);
}
