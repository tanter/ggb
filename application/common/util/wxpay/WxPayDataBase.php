<?php


namespace app\client\util\wxpay;


class WxPayDataBase
{
    /**
     * @var array
     */
    protected $values = [];

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->values[$name] = $value;
    }

    /**
     * __get
     *
     * @param mixed $name
     * @access public
     * @return void
     */
    public function __get($name)
    {
        return $this->values[$name];
    }

    /**
     * __isset
     *
     * @param mixed $name
     * @access public
     * @return void
     */
    public function __isset($name)
    {
        return array_key_exists($name, $this->values);
    }

    /**
     * setSign 设置签名
     *
     * @return void
     */
    public function setSign($key)
    {
        $sign = Tool::makeSign($this->values, $key);
        $this->values['sign'] = $sign;
    }

    /**
     * getValues 获取设置的值
     *
     * @return array
     */
    public function getValues()
    {
        $values = $this->values;
        $sign = null;
        if(isset($values['sign'])){
            $sign = $values['sign'];
            unset($values['sign']);
        }
        ksort($values);
        if($sign !== null){
            $values['sign'] = $sign;
        }
        return $values;
    }
}