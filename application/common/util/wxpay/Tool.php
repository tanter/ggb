<?php


namespace app\client\util\wxpay;


class Tool
{
    /**
     * 生成随机字符串，不长于32位
     *
     * @param int $length
     * @return string
     */
    public static function getNonceStr($length = 32)
    {/*{{{*/
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $str   = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }/*}}}*/

    /**
     * array 转为 xml
     *
     * @param array $data | object
     * @return string
     * @throws WxPayException
     */
    public static function arrayToXml($data = [])
    {/*{{{*/
        if (!is_array($data) || count($data) <= 0) {
            throw new WxPayException('数组数据异常!');
        }
        $xml = '<xml>';
        foreach ($data as $key => $val) {
            if (is_numeric($val)) {
                $xml .= '<' . $key . '>' . $val . '</' . $key . '>';
            } else {
                $xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
            }
        }
        $xml .= '</xml>';
        return $xml;
    }/*}}}*/


    /**
     * xml 转为 array
     *
     * @param string $xml
     * @return mixed
     * @throws WxPayException
     */
    public static function xmlToArray($xml = '')
    {/*{{{*/
        if (empty($xml))
            throw new WxPayException('xml数据异常!');
        // 将XML转为array
        // 禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $data;
    }/*}}}*/

    /**
     * 格式化参数为URL参数
     *
     * @param array $data
     * @return string
     */
    public static function toUrlParams($data = [])
    {/*{{{*/
        $buff = '';
        foreach ($data as $key => $val) {
            if ($key != 'sign' && $val != '' && !is_array($val)) {
                $buff .= $key . '=' . $val . '&';
            }
        }
        $buff = trim($buff, '&');
        return $buff;
    }/*}}}*/

    /**
     * 生成签名
     *
     * @param array $data
     * @return string
     */
    public static function makeSign($data = [], $key='')
    {
        /*{{{*/
        // 签名步骤一：按字典排序参数
        ksort($data);
        $string = self::toUrlParams($data);
        // 签名步骤二：在string后加入key
        $string = $string . '&key=' . $key;
        // 签名步骤三：MD5加密
      	//dump($string);
        $string = md5($string);
        // 签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }/*}}}*/

    /**
     * 获取客户端IP地址
     *
     * @param int $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param bool $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    public static function getClientIP($type = 0, $adv = false)
    {/*{{{*/
        $type      = $type ? 1 : 0;
        static $ip = null;
        if (null !== $ip) {
            return $ip[$type];
        }

        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) {
                    unset($arr[$pos]);
                }
                $ip = trim(current($arr));
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip   = $long ? [$ip, $long] : ['0.0.0.0', 0];
        return $ip[$type];
    }/*}}}*/

    /**
     * 获取毫秒级时间戳
     *
     * @return array|string
     */
    public static function getMillisecond()
    {/*{{{*/
        $time  = explode (" ", microtime ());
        $time  = $time[1] . ($time[0] * 1000);
        $time2 = explode( ".", $time );
        $time  = $time2[0];
        return $time;
    }/*}}}*/

    /**
     * post方式提交数据到对应的接口
     *
     * @param string $data    需要post的xml数据
     * @param $url string    url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $timeout   请求执行超时时间，默认30s
     * @return mixed
     * @throws WxPayException
     */
    public static function postCurl($data, $url, $useCert = false, $timeout = 30)
    {
        /*{{{*/
        $ch = curl_init();
        // 设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        // 如果有配置代理这里就设置代理
        if (WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WxPayConfig::CURL_PROXY_PORT != 0) {
            curl_setopt($ch, CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
            curl_setopt($ch, CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 严格校验
        // 设置header
        curl_setopt($ch, CURLOPT_HEADER, false);
        // 要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($useCert == true) {
            // 设置证书
            // 使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);
        }
        // post方式提交数据
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // 运行curl
        $result = curl_exec($ch);


        // 返回结果
        if ($result) {
            curl_close($ch);
            return $result;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WxPayException('curl出错，错误码: ' . $error);
        }
    }/*}}}*/

    /**
     * curl GET提交
     *
     * @param $url
     * @param int $timeout
     * @return mixed
     */
    public static function getCurl($url, $timeout = 5)
    {/*{{{*/
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); // 设置超时
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;

    }/*}}}*/

    /**
     * 获取用户openid
     */
    public static function getOpenid()
    {
        // 通过code获取openid
        if (!isset($_GET['code'])) {
            // 触发微信返回code码
            $url     = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];
            $baseUrl = urlencode($url);
            $redirectUrl = self::createOauthUrlForCode($baseUrl);
            header("Location: $redirectUrl");
            exit();
        } else {
            // 获取code，通过code获取openid
            $code = $_GET['code'];
            // 构造获取openid的链接
            $url  = self::createOauthUrlForOpenid($code);
            // 发送get请求
            $data = self::getCurl($url);
            $data = json_decode($data, true);
            return $data['openid'];

        }
    }

    /**
     * 构造获取code的url连接
     *
     * @param string $redirectUrl 微信服务器回跳的url，需要url编码
     * @return string
     */
    public static function createOauthUrlForCode($redirectUrl)
    {
        $params['appid']         = WxPayConfig::APPID;
        $params['redirect_uri']  = $redirectUrl;
        $params['response_type'] = 'code';
        $params['scope']         = 'snsapi_base';
        $params['state']         = 'STATE#wechat_redirect';
        $queryString = self::toUrlParams($params);
        return 'https://open.weixin.qq.com/connect/oauth2/authorize?' . $queryString;
    }

    /**
     * 构造通过code获取openid的url链接
     *
     * @param $code
     * @return string
     */
    public static function createOauthUrlForOpenid($code)
    {
        $params['appid']      = WxPayConfig::APPID;
        $params['secret']     = WxPayConfig::APPSECRET;
        $params['code']       = $code;
        $params['grant_type'] = 'authorization_code';
        $queryString = self::toUrlParams($params);
        return 'https://api.weixin.qq.com/sns/oauth2/access_token?' . $queryString;
    }
}