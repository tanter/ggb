<?php


namespace app\client\util\wxpay;


class WxPayConfig
{
    /**
     * 微信公众号信息配置
     *
     * APPID: 绑定支付的APPID，必须配置
     * MCHID: 商户号 必须配置
     * KEY: 商户支付密钥，必须配置
     * APPSECRET: 公众号secert (仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置)
     * @var string
     */
    const APPID = '';
    const MCHID = '';
    const KEY   = '';
    const APPSECRET = '';
    //=======【证书路径设置】==================================
    /**
     * 证书路径，绝对路径(仅退款、撤销订单时需要)
     */
    const SSLCERT_PATH = '../cert/apiclient_cert.pem';
    const SSLKEY_PATH  = '../cert/apiclient_key.pem';

    //=======【curl代理设置】===================================
    const CURL_PROXY_HOST = "0.0.0.0";
    const CURL_PROXY_PORT = 0;

    //=======【上报信息配置】===================================
    const REPORT_LEVENL = 1;

    //=======【支付异步通知URL】===================================
    const NOTIFY_URL = '';
}