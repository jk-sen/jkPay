<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/19
 * Time: 18:27
 */

namespace jikesen\jkPay\Utils;


use jikesen\jkPay\Convention\ConfigInterFace;

class Config implements ConfigInterFace
{
    /**
     * @var string $private key
     */
    protected $private_key = '';

    /**
     * @var string public key
     */
    protected $public_key = '';

    /**
     * @var instance of config
     */
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
    public static function getInstance(): object
    {
        if (!(self::$_instance instanceof ConfigInterFace)) {
            self::$_instance = new Config();
        }
        return self::$_instance;
    }

    /**
     * @param $property_name
     * @return null
     */
    public function __get($property_name)
    {
        return isset($this->$property_name) ? $this->$property_name : null;
    }

    /**
     * @param $property_name
     * @param $value
     */
    public function __set($property_name, $value)
    {
        $this->$property_name = $value;
    }
}