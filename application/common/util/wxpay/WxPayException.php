<?php


namespace app\client\util\wxpay;


class WxPayException extends \Exception
{
    /**
     * @return string
     */
    public function errorMessage()
    {
        return $this->getMessage();
    }
}