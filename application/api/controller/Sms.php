<?php
namespace app\api\controller;


class Sms extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    // 我交易的c2c
    public function sms_send()
    {
        /**
         * user_string: 18771011212
        mobile_code:
        scene: change_password
        lang: zh
        country_code: +86
         */
        // 失败
        $data = '{"type":"error","message":"\u8d26\u53f7\u4e0d\u5b58\u5728"}';
        // 成功
        $data = '{"type":"ok","message":"\u53d1\u9001\u6210\u529f"}';
        return self::j($data);
    }
}
