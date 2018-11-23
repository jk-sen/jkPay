<?php
/**
 * Created by PhpStorm.
 * User: jkSen
 * Date: 2018/11/9
 * Time: 13:04
 */

namespace jikesen\jkPay;


class Pay
{
    /**
     * @var app configs
     */
    protected $config;

    /**
     * JkPay constructor.
     * @param array $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param $func
     * @param $config  Global configuration
     * @return mixed
     */
    public static function __callStatic($func, $config)
    {
        $config = $config[0];
        $app = new self($config);
        return $app->pay($func);
    }

    public function pay($func)
    {
        $pay_app = __NAMESPACE__ . '\\Apps\\' . $func . '\Pay';
        return new $pay_app($this->config);
    }
}