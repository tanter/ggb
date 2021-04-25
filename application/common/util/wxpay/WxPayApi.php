<?php


namespace app\client\util\wxpay;


class WxPayApi
{
    /**
     * 统一下单请求地址
     */
    const UNIFORM_ORDER_URL = 'https://api.mch.weixin.qq.com/pay/unifiedorder';


    /**
     * 统一下单接口
     *
     * @param $inputObj
     * @param int $timeOut
     * @return mixed
     * @throws WxPayException
     */
    public static function unifiedOrder($inputObj, $timeOut = 30)
    {
        // 检测必填参数
        if (!isset($inputObj->appid)) {
            throw new WxPayException('缺少统一下单接口必填参数公众号ID：appid!');
        } elseif (!isset($inputObj->mch_id)) {
            throw new WxPayException('缺少统一下单接口必填参数商户号：mch_id!');
        }  elseif (!isset($inputObj->sign)) {
            throw new WxPayException('缺少统一下单接口必填参数签名：sign!');
        } elseif (!isset($inputObj->body)) {
            throw new WxPayException('缺少统一下单接口必填参数商品描述：body!');
        } elseif (!isset($inputObj->out_trade_no)) {
            throw new WxPayException('缺少统一下单接口必填参数商户订单号：out_trade_no!');
        } elseif (!isset($inputObj->total_fee)) {
            throw new WxPayException('缺少统一下单接口必填参数总金额：total_fee!');
        } elseif (!isset($inputObj->notify_url)) {
            throw new WxPayException('缺少统一下单接口必填参数通知地址：notify_url!');
        } elseif (!isset($inputObj->trade_type)) {
            throw new WxPayException('缺少统一下单接口必填参数交易类型：trade_type!');
        } elseif (!isset($inputObj->nonce_str)) {
            throw new WxPayException('缺少统一下单接口必填参数随机字符串：nonce_str!');
        } elseif (!isset($inputObj->spbill_create_ip)) {
            throw new WxPayException('缺少统一下单接口必填参数终端IP：spbill_create_ip!');
        }
        // 关联参数
        if ($inputObj->trade_type == 'JSAPI' &&  !isset($inputObj->openid)) {
            throw new WxPayException("统一下单接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！");
        }
        if($inputObj->trade_type == 'NATIVE' && !isset($inputObj->product_id)) {
            throw new WxPayException("统一下单接口中，缺少必填参数product_id！trade_type为NATIVE时，product_id为必填参数！");
        }

        // 格式化xml数据
        $xml = Tool::arrayToXml($inputObj->getValues());

        // 请求开始时间
//        $startTimeStamp = Tool::getMillisecond();
        // 发送请求
        $response = Tool::postCurl($xml, self::UNIFORM_ORDER_URL, false, $timeOut);
        $result   = Tool::xmlToArray($response);
        return $result;
    }
}