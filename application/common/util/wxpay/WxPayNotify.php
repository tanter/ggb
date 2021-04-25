<?php


namespace app\client\util\wxpay;


class WxPayNotify extends WxPayDataBase
{

    /**
     * @param $xml
     */
    public function replayNotify($xml)
    {
        echo $xml;
    }
}