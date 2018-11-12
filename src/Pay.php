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

    public function test(): string
    {
        return "hello , this is jike_pay test demo";
    }

    /**
     * weixin & zhifubao 构造
     * Pay constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
}