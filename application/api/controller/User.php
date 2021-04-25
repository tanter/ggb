<?php
namespace app\api\controller;


class User extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    // 登陆界面
    public function login()
    {
        $user_string = input('user_string');
        $password = input('password');
        $sms_code = input('sms_code');
        $country_code = input('country_code');

        $data = [
            'message'=>'1d609d2b0628deadd01d1426139d46c3',
            'type'=>'ok'
        ];
        return self::json($data);
    }
    // 行情
    public function info()
    {
        $data = '{"type":"ok","message":{"id":2,"account_number":"18339827721","type":1,"nationality":"China","country_code":"86","phone":"18339827721","email":"","time":"2019-07-11 18:33:30","parent_id":1,"head_portrait":"http:\/\/jyxt.ys.13mv.com\/mobile\/images\/user_head.png","extension_code":"3cyi","status":0,"is_auth":"","nickname":"","wallet_address":"","parents_path":"1","agent_id":0,"agent_note_id":1,"push_status":0,"candy_number":"10000.0000","zhitui_real_number":0,"real_teamnumber":3,"top_upnumber":"10000.000000","is_realname":2,"is_atelier":0,"agent_path":null,"review_status":1,"name":"\u97e9\u5ddd\u666e","account":"183******721","is_seller":0,"create_date":"2019-07-11 18:33:30","usdt":"10000.00000","caution_money":"13.00389080","parent_name":"admin","my_agent_level":"\u666e\u901a\u7528\u6237"}}';
        return self::j($data);
    }
    // 身份认证
    public function center()
    {
        // 已认证
        $data = '{"type":"ok","message":{"id":2,"phone":"18339827721","email":"","review_status":2,"name":"\u97e9\u5ddd\u666e","card_id":"12******13","account":"183******721","is_seller":0,"create_date":"","usdt":"0.00000","caution_money":"13.00389080","parent_name":"-\/-","my_agent_level":"\u666e\u901a\u7528\u6237"}}';
        // 审核中
        $data = '{"type":"ok","message":{"id":2,"phone":"18339827721","email":"","review_status":1,"name":"\u97e9\u5ddd\u666e","card_id":"12******13","account":"183******721","is_seller":0,"create_date":"","usdt":"0.00000","caution_money":"13.00389080","parent_name":"-\/-","my_agent_level":"\u666e\u901a\u7528\u6237"}}';
        return self::j($data);
    }
    // 下一步检测短信验证码
    public function check_mobile()
    {
        /**
         * user_string: 18888888888
        mobile_code: 1234
        lang: zh
        country_code: +86
         */
        $data = '{"type":"error","message":"\u9a8c\u8bc1\u7801\u9519\u8bef!"}';
        $data = '{"type":"ok","message":"\u53d1\u9001\u6210\u529f"}';
        return self::j($data);
    }
    // 更改密码
    public function forget()
    {
        /**
         * account: 15799999999
        password: 123456
        repassword: 123456
        code: 1234
         */
        $data = '{"type":"error","message":"\u9a8c\u8bc1\u7801\u4e0d\u6b63\u786e"}';
        $data = '{"type":"ok","message":"\u53d1\u9001\u6210\u529f"}';
        return self::j($data);
    }
    public function cash_info()
    {
        $data = '{"type":"ok","message":{"id":6,"user_id":2,"bank_name":"\u6c99\u96d5","bank_account":"32434645645456456","real_name":"\u7684\u590d\u53e4\u98ce\u683c","alipay_account":"12344534545646","wechat_nickname":"\u68b5\u8482\u5188","wechat_account":"","create_time":"2019-08-05 17:03:37","account_number":"18339827721"}}';
        return self::j($data);
    }
    public function cash_save()
    {
        /**
         * real_name: 的复古风格
        bank_name: 沙雕
        bank_account: 32434645645456456
        alipay_account: 12344534545646
        wechat_nickname: 梵蒂冈
        wechat_account:
         */
        $data = '{"type":"ok","message":"\u4fdd\u5b58\u6210\u529f"}';
        return self::j($data);
    }
    public function logout()
    {
        $data = '{"type":"ok","message":"\u53d1\u9001\u6210\u529f"}';
        return self::j($data);
    }
}
