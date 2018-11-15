<?php
/**
 * Created by PhpStorm.
 * User: user
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
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $func 调用的支付方式 将调用统一支付接口来分发请求
     * @param array $param 选择支付方式的配置
     */
    public static function __callStatic(string $func, array $param)
    {
        $app = new self($param);
        echo $func;die;
    }
}