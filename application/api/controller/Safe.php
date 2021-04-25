<?php
namespace app\api\controller;


class Safe extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    public function safe_center()
    {
        $data = '{"type":"ok","message":{"mobile":"18339827721","email":"","gesture_password":""}}';
        return self::j($data);
    }
    // 修改密码
    public function update_password()
    {
        /**
         * password: 123123
        re_password: 123123
        code: 1234
         */
        $data = '{"type":"ok","message": "修改密码成功"}';
        return self::j($data);
    }
}
