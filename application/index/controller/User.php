<?php
namespace app\index\controller;


class User extends Base
{
  	public function __construct()
	{
		parent::__construct();
	}
  	public function info()
  	{
  		$token = input('token');
  		return self::json(0, $this->get_user_info(['token'=>$token]));
  	}
  	// 获取账号安全等级
  	public function accountSafetyLevel()
  	{
  		$token = input('token');
  		$user = db('user')->where(['token'=>$token])->find();
  		$level = 0;
  		if($user['phone']) $level += 60;
  		if($user['password']) $level += 20;
  		if($user['transaction_password']) $level += 20;
  		return self::json(0, ['level'=>$level]);
  	}
  	// 设置支付密码
  	public function saveTpwd()
  	{
        $password = input('password');
        $password_again = input('password_again');
        $code = input('code');
        $token = input('token');
        $phone = input('phone');
        if($phone){
            // 绑定手机号
            if (empty($phone) || empty($code)){
                return self::json(1, null, '参数错误');
            }
            $scene = 'sendSms';
            $opts['phone'] = $phone;
            self::verify($opts, $scene);
            db('user')->where(['token'=>$token])->update(['phone'=>$phone]);
            return self::json(0, null, '绑定成功');
        }else{
            // 设置支付密码
            if (empty($password) || empty($password_again) || empty($code)){
                return self::json(1, null, '参数错误');
            }
            if ($password_again != $password){
                return self::json(1, null, '两次密码不相等');
            }
            $user = db('user')->where(['token'=>$token])->find();
            if($user['phone']){
                $account = $user['phone'];
            }else{
                $account = $user['email'];
            }
            $r_code = $this->getCodeCache($account);
            if(empty($r_code) || $r_code != $code){
                self::json(1, null, '验证码不相等');
            }
            db('user')->where(['token'=>$token])->update(['transaction_password'=>md5($password)]);
            return self::json(0, null, '设置密码成功');
        }
  	}
    // 修改密码
    public function updatePassword()
    {
      $account = input('account');
      $password = input('password');
      $password_again = input('password_again');
      $code = input('code');
      $token = input('token');
      if(!empty($token)){
        $user = db('user')->where(['token'=>$token])->find();
        if(!empty($user['phone'])){
          $account = $user['phone'];
        }else if(!empty($user['email'])){
          $account = $user['email'];
        }else{
          return self::json(1, null, '请重新登陆');
        }
      }

      if (empty($account) || empty($password) || empty($password_again) || empty($code)){
        return self::json(1, null, '参数错误');
      }
      if ($password_again != $password){
        return self::json(1, null, '两次密码不相等');
      }

      $r_code = $this->getCodeCache($account);
      if(empty($r_code) || $r_code != $code){
        self::json(1, null, '验证码不相等');
      }
      if(strstr($account,'@')){
        $consition['email'] = $account;
      } else {
        $consition['phone'] = $account;
      }
      db('user')->where($consition)->update(['password'=>md5($password)]);
      return self::json(0, null, '设置密码成功');
    }
    
    private function get_id_card_relative_address($url)
    {
        $arr = explode('/', $url);
        return "./uploads/" . $arr[count($arr) - 1];
    }

    // 身份认证
    public function userIdCard()
    {
        $id_card_1 = input('id_card_face');
        $id_card_0 = input('id_card_back');
        if (empty($id_card_1) || empty($id_card_0)) {
            // 身份证真反面不能为空
            return self::json(1,'', '身份证真反面不能为空');
        }
        $face = self::idenDist($this->get_id_card_relative_address($id_card_1), 'face');
        $back = self::idenDist($this->get_id_card_relative_address($id_card_0), 'back');
        if ($face['success'] !== true || $back['success'] !== true) {
            // 返回错误信息 $face['message'] 和 $back['message'] （详情查看 idenDist ）
          $msg =  isset($face['message']) ? $face['message'] : '';
          $msg .= isset($back['message']) ? $back['message'] : '';
          return self::json(1, '', $msg);
        }
        $uid = self::get_uid();
        $data = [
            'user_id' => $uid,
            'id_card_face_url' => $id_card_1,
            'id_card_back_url' => $id_card_0,
            'address' => $face['address'],
            'birth' => $face['birth'],
            'sex' => $face['sex'],
            'name' => $face['name'],
            'nationality' => $face['nationality'],
            'num' => $face['num'],
            'face_request_id' => $face['request_id'],
            'back_request_id' => $back['request_id'],
            'start_date' => $back['start_date'],
            'end_date' => $back['end_date'],
            'issue' => $back['issue'],
            'add_time' => self::getDate()
        ];
        db('user_id_card')->where(['user_id'=>$uid])->update(['is_delete'=>1]);
        if (db('user_id_card')->insertGetId($data)) {
            return self::json(0, [], '上传成功，等待审核');
        } else {
            // 保存失败
            return self::json(1, '', '身份识别失败，请联系客服');
        }
    }
    // 更新用户信息
    public function updateInfo()
    {
      $data = $this->params();
      $token = input('token');
      db('user')->where(['token'=>$token])->update($data);
      return self::json(0, '', '操作成功');
    }

    // 获取合约设置
    public function getSetting()
    {
        $data = db('currency_setting')->where(['is_delete'=>0])->select();
        return self::json(0, $data);
    }

    // 获取用户身份证审核信息
    public function idcardinfo()
    {
        $uid = self::get_uid();
        $idcard = db('user_id_card')->where(['user_id'=>$uid, 'is_delete'=>0])->order('id desc')->find();
        if(empty($idcard)){
            return self::json(0, ['is_auth'=>0]);
        }
        $is_auth = $idcard['is_auth'];
        // 是否审核 1是 0否 -1驳回
        $is_read = $idcard['is_read'];

        if($is_auth == -1){
            $data = [
                'is_auth'=>$is_auth
            ];
            if($is_read==0){
                $data['message_zh'] = $idcard['message_zh'];
                $data['message_en'] = $idcard['message_en'];
                db('user_id_card')->where(['id'=>$idcard['id']])->update(['is_read'=>1]);
            }
        }else{
            $is_auth += 1;
            $data = [
                'is_auth'=>$is_auth
            ];
        }
        return self::json(0, $data);
    }

    //获取订单记录
    public function getDealList()
    {
        $deal_type = intval(input('deal_type'));
        $page = intval(input('page'));
        $limit = intval(input('limit',10));
        $status = intval(input('status'));
        $uid = self::get_uid();
        $sql = "select a.* , b.`name`, IFNULL(b.phone,b.email) as phone
                from jyxt_user_deal a
                LEFT JOIN jyxt_user b on b.id = a.user_id
                where a.user_id = $uid
                and deal_type = $deal_type
                and `status` = $status";
        $first = ($page - 1) * $limit;
        $sql .= " order by a.id desc limit $first, $limit ";
        $data = db()->query($sql);

        return self::json(0, ['list'=>$data]);
    }

}
