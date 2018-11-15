<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/15
 * Time: 17:51
 */

namespace jikesen\jkPay\Apps\WxPay;


use jikesen\jkPay\Convention\ConventionAppInterface;

class Pay implements ConventionAppInterface
{
    public function __construct($config)
    {
        $this->config = $config;
    }
    /**
     * @inheritDoc
     */
    public function pay()
    {
        // TODO: Implement pay() method.
        echo 'wx pay';
    }

    /**
     * @inheritDoc
     */
    public function query()
    {
        // TODO: Implement query() method.
    }

    /**
     * @inheritDoc
     */
    public function refund()
    {
        // TODO: Implement refund() method.
    }

    /**
     * @inheritDoc
     */
    public function callback()
    {
        // TODO: Implement callback() method.
    }
}