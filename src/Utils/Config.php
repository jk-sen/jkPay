<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/19
 * Time: 18:27
 */

namespace jikesen\jkPay\Utils;


class Config
{
    /**
     * @var string 支付宝私钥
     */
    protected $private_key = '';

    /**
     * @var string 支付宝公钥
     */
    protected $public_key = '';

    private static $_instance = null;

    /**
     * Config constructor.
     */
    private function __construct()
    {
    }

    /**
     *
     */
    private function __clone()
    {
    }

    /**
     * @return Config|null
     */
    public static function getInstance()
    {
        if (!(self::$_instance instanceof Config)) {
            self::$_instance = new Config();
        }
        return self::$_instance;
    }

    public function __get($property_name)
    {
        return isset($this->$property_name) ? $this->$property_name : null;
    }

    public function __set($property_name, $value)
    {
        $this->$property_name = $value;
    }
}