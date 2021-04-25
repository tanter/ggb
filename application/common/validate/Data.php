<?php
namespace app\common\validate;

use think\Validate;

/**
 * 代理端验证
 * Class Login
 * @package app\admin\validate
 */
class Data extends Validate {

    protected $rule = [
        'nickname' => 'checkNickname',
        'username' => 'require|checkAccount',
        'password' => 'require|checkPassWord',
        'id'=>'require|checkId',
        'token'=>'require|checkToken',
        'path'=>'require|checkRoute',
        'phone'=>'require|checkPhone',
        'email'=>'require|checkEmail',
        'wechat_number'=>'require|checkWechatNumber'
    ];
    protected function checkNickname($value){
        if(empty($value))return true;
        if(strlen($value) > 32) return '昵称长度不能超过32字节';
    }
    //验证登录账号
    protected function checkAccount($value){
      	$re = '/^(\w){6,16}$/';
        if(preg_match($re,$value))return true;
        return '用户名由6-16个字母、数字、下划线组成';
    }
    //验证登录密码
    protected function checkPassWord($value){
        $re = '/^(\w){6,32}$/';
        if(preg_match($re,$value))return true;
        return '密码由6-32个字母、数字、下划线组成';
    }
    //验证id
    protected function checkId($value){
        $value = intval($value);
        if(empty($value))return 'ID不能为字符串，请重新登录';
        return true;
    }
    //验证token是否有效
    protected function checkToken($value){
        $re = '/^[A-Za-z0-9]{16}$/';
        if(preg_match($re,$value))return true;
        return 'TOKEN不正确，请重新登录';
    }
    //验证路由
    protected function checkRoute($value){
        $re = '/^[a-z_\/]+$/';
        if(preg_match($re,$value))return true;
        return '路由错误，请重新登录';
    }
    //验证11位手机号码
    protected function checkPhone($value){
        $re = '/^1[34578]\d{9}$/';
        if(preg_match($re,$value)) return true;
        return '手机号码有误，请重填';
    }
    protected function checkEmail($value){
        $re= '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
        // $re="/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i";
        if(preg_match($re,$value)) return true;
        return '邮箱有误，请重填';
    }
    //验证微信号
    protected function checkWechatNumber($value){
        if(strlen($value)>30)return '微信号字节长度不能超过30';
        return true;
    }
    protected $message = [
        'username.require' => '账号不能为空',
        'password.require' => '密码不能为空',
        'id.require'=>'ID为空,请重新登录',
        'token.require'=>'TOKEN为空,请重新登录',
        'path.require'=>'路由为空，请重新登录',
        'phone.require'=>'手机号码不能为空',
        'wechat_number.require'=>'微信号不能为空'
    ];

    protected $scene = [
        //登录
        'login'=>['username','password'],
        //添加账号
        'add1'=>['checkNickname','username','password'],
        'add2'=>['checkNickname','username'],
        
        //权限参数
        'auth'=>['id','token','path'],
        //发送短信验证码
        'sendSms'=>['phone'],
        'sendEmail'=>['email'],

        //基本信息绑定微信号
        'baseInfo'=>['id','wechat_number']
    ];
}