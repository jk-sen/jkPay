<?php
/**
 * Created by PhpStorm.
 * User: sen
 * Date: 2018/11/9
 * Time: 22:05
 */

namespace jikesen\jkPay\Convention;


interface ConventionPayInterface
{
    /**
     * @param $param 支付参数
     * @return mixed
     */
    public function pay($param);
}