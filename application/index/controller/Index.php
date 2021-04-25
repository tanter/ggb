<?php
namespace app\index\controller;


class Index extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    public function test()
    {
        $sql = "call proc_yjpc(54,@a);";
        $res = db()->query($sql);
        dump($res[0][0]['_status']);
    }
    public function userLogin()
    {
        $username = input('account');
        $password = input('password');
        $prefix   = input('prefix');
        $index    = intval(input('index'));
        $data['password'] = md5($password);
        if ($index === 0) {
            $data['phone'] = $username;
        } else {
            $data['email'] = $username;
        }
        $user = db('user')->where($data)->find();
        if(empty($user)) {
            return self::json(0, null, '账号密码不存在');
        }
        $token = self::get_token($user['id']);
        db('user')->where(['id'=>$user['id']])->update(['token'=>$token]);

        return self::json(0, $this->get_user_info(['id'=>$user['id']]));
    }

    public function getTelCode()
    {
        $data = db('country')->select();
        return self::json(0, $data);
    }

    // 获取验证码
    public function getCode()
    {
        $index = intval(input('index'));
        $account = input('account');
        $type = input('type'); //type: bindmpwd  bindphone
        $code = self::get_code();

        // 绑定交易密码
        if($type === 'bindmpwd') {
            $user = db('user')->where(['token'=>input('token')])->find();
            if($user['phone']){
                $index = 0;
                $account = $user['phone'];
            } else if($user['email']){
                $index = 1;
                $account = $user['email'];
            }else {
                return self::json(1, null, '您还未绑定手机或邮箱');
            }
        }
        // 绑定手机号
        else if($type === 'bindphone'){
            $index = 0;
        } else if ($type === 'forgetpwd'){
            // 忘记密码
            $index = 0;
            if(strstr($account,'@')){
                $index = 1;
            }
        } else {
            //register 注册账号
        }

        if($index === 0){
            $scene = 'sendSms';
            $opts['phone'] = $account;
        }else{
            $scene = 'sendEmail';
            $opts['email'] = $account;
        }

        self::verify($opts, $scene);

        // 判断账号是否存在
        $id = db('user')->where($opts)->value('id');

        if($type == 'register'&&$id){
            return self::json(1, null, '该账号已存在');
        }
        if($type == 'forgetpwd' && !$id){
            return self::json(1, null, '该账号不存在');
        }

        if($index === 0){
            $res = $this->sendTelSms($account, $code);
        }else{
            $res = $this->sendEmailSms($account, $code);
        }
        if($res !== true){
            return self::json(1, null, '短信验证码发送失败，请联系人客服。');
        }
        $this->setCodeCache($account, $code);
        return self::json(0, ['code'=>$code], '您的验证码已发送，请注意查收。');
    }
    // 用户注册
    public function userRegister()
    {
        $index = intval(input('index'));
        // $pid = intval(input('pid', 1));
        $country = input('country');
        $prefix = input('prefix');
        $account = input('account');
        $password = input('password');
        $password_again = input('password_again');
        $code = input('code');
        $invitation_code = input('invitation_code');
        if (empty($account) || empty($password) || empty($password_again) || empty($code) || empty($invitation_code)){
            return self::json(1, null, '参数错误');
        }
        if ($password_again != $password){
            return self::json(1, null, '两次密码不相等');
        }
        if($index === 0){
            $scene = 'sendSms';
            $opts['phone'] = $account;
        }else{
            $scene = 'sendEmail';
            $opts['email'] = $account;
        }
        self::verify($opts, $scene);
        if(db('user')->where($opts)->value('id')){
            return self::json(1, null, '该账号已存在');
        }
        $r_code = $this->getCodeCache($account);
        if(empty($r_code) || $r_code != $code){
            self::json(1, null, '验证码不相等');
        }
        $pid = db('admin')->where(['code'=>$invitation_code])->value('id');
        if(empty($pid)){
            return self::json(1, null, '邀请吗不存在');
        }
        $data = [
            'p_id' => $pid,
            'phone' => $index === 0 ? $account : null,
            'email' => $index === 0 ? null : $account,
            'password' => md5($password),
            'add_time' => self::getDate(),
            'prefix' => $prefix,
            'country' => $country
        ];
        $id = db('user')->insertGetId($data);
        $invitation_code = $this->create_invitation_code($id);

        db('user')->update(['id'=>$id, 'invitation_code'=>$invitation_code]);
        if($id){
            $currency = db('currency')->where('type=1')->select();
            $data = [];
            $time = self::getDate();
            foreach ($currency as $index => $item) {
                $data[] = [
                    'user_id' =>$id,
                    'currency' => $item['name'],
                    'type' => $item['type'],
                    'add_time' => $time
                ];
            }
            db('user_wallet')->insertAll($data);
            return self::json(0, null, '注册成功');
        }else{
            return self::json(1, null, '注册失败，请联系客服人员');
        }
    }
    public function miss()
    {
        self::json(0, null, '请求发生错误');
    }
    // 获取币种的交易手续费
    private function get_deal_rate($type, $currency, $value)
    {
        return db('currency')->where(['type'=>$type, 'name'=>$currency])->value($value);
    }
    // 获取交易手续费和手数比例已经当前余额
    public function getInfo()
    {
        $token = input('token');
        $currency = input('currency');
        $type = input('type');

        $data['deal_rate'] = $this->get_deal_rate($type, $currency, 'deal_rate');
        $data['lot'] = $this->get_deal_rate($type, $currency, 'lot');

        if(!empty($token)){
            $uid = self::get_uid();
            if($type == 1){
                $positions = db('user_wallet')->where(['user_id'=>$uid, 'type'=>1, 'currency'=>$currency])->value('positions');
            }else{
                $positions = 0;
            }
            $data['wallet'] = [
                'balance' => self::get_user_felid_value($uid, $type == 1 ? 'bb_usdt' : 'hy_usdt'),
                'positions' => $positions
            ];
        }else{
            $res['balance'] = 0;
            $res['positions'] = 0 ;
            $data['wallet'] = $res;
        }
        $data['usdt'] = 'USDT';
        $data['unit'] = $currency;

        return self::json(0, $data); //15329611241
    }

    // 获取最新价和涨幅
    public function getCurrencyPriceAndIncrease()
    {
        $type = intval(input('type'));
        $currency = input('currency');

        $sql = "select a.*
                from jyxt_currency_jy a,jyxt_currency b
                where b.status = 0
                and  b.type = a.type 
                and b.symbol = a.symbol
                and a.type = $type order by a.symbol asc";

        $list = db()->query($sql);
        $price = [];
        $value = '';
        $deal = '';
        foreach ($list as $index=>$item){
            if(empty($currency)){
                $deal = $item['deal'];
                $value = $item['value'];
            }
            if($currency == $item['currency']){
                $deal = $item;
            }
            $arr = explode(',', $item['value']);

            $price[] = [
                'name' => $item['currency'],
                'symbol' => $item['symbol'],
                'price' => floatval($arr[2]),
                'increase' => floatval($arr[6])
            ];
        }
        $data['price'] = $price;
        $data['deal'] = $deal;
        $data['value'] = $value;
        $currency = $list[0]['currency'];
        $data['deal_rate'] = $this->get_deal_rate($type, $currency, 'deal_rate');
        $data['lot'] = $this->get_deal_rate($type, $currency, 'lot');
        $data['usdt'] = 'USDT';
        $data['cny'] = $currency;
        return self::json(0, $data); //15329611241
    }
    // 首页公告
    public function getGG()
    {
        $data = db('text')->field('id,title')->where(['type'=>'gonggao'])->select();
        return self::json(0, $data);
    }
    public function getText()
    {
        $id = intval(input('id'));
        $data = db('text')->where(['id'=>$id])->find();
        return self::json(0, $data);
    }
    // 首页币种信息
    public function getCutttencyInfo()
    {
        $lang = input('lang');
        $type = 1;
        $sql = "select a.*
                from jyxt_currency_jy a,jyxt_currency b
                where b.status = 0
                and  b.type = a.type 
                and b.symbol = a.symbol
                and a.type = $type";

        $list = db()->query($sql);
        $price = [];
        foreach ($list as $index=>$item){
            $arr = explode(',', $item['value']);
            //  // value  // 交易对、币种、当前价格、人民币价格、最高价、最低价、涨幅、24小时成交量
            $price[] = [
                'title' => $item['symbol'],
                'grow' => floatval(isset($arr[6]) ? $arr[6] : 0),
                'value' =>round(floatval(isset($arr[2])? $arr[2] : 0), 4),
                'ht'=>$lang == 'en' ? '24H Vol' : '24H量',
                'number'=>round(isset($arr[7]) ? $arr[7] : 0, 4)
            ];
        }
        // {"title":"BTC/USDT","grow":"1.71","value":"10078.4100","ht":"24H量","number":"24145.0286"}
        // $data = '[{"title":"BTC/USDT","grow":"1.71","value":"10078.4100","ht":"24H量","number":"24145.0286"},{"title":"XRP/USDT","grow":"0.09","value":"10078.4100","ht":"24H量","number":"24145.0286"},{"title":"LTC/USDT","grow":"-2.59","value":"10078.4100","ht":"24H量","number":"24145.0286"},{"title":"EOS/USDT","grow":"-1.69","value":"10078.4100","ht":"24H量","number":"24145.0286"},{"title":"BCH/USDT","grow":"-0.09","value":"10078.4100","ht":"24H量","number":"24145.0286"},{"title":"ETH/USDT","grow":"-0.83","value":"10078.4100","ht":"24H量","number":"24145.0286"}]';
        return self::json(0, $price);
    }
    public function getBanner()
    {
        $lang = input('lang');
        $data = [
            "/static/image/banner1.jpg",
            "/static/image/banner2.jpg",
            "/static/image/banner3.jpg"];
        if($lang=='en'){
            $data = [
                "/static/image/banner1-en.jpg",
                "/static/image/banner2-en.jpg",
                "/static/image/banner3-en.jpg"];
        }
        return self::json(0, $data);
    }
}
