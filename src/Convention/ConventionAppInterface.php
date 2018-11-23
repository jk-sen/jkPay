<?php
/**
 * Created by PhpStorm.
 * User: sen
 * Date: 2018/11/9
 * Time: 22:05
 */

namespace jikesen\jkPay\Convention;


interface ConventionAppInterface
{
    /**
     * @param $payType 支付类型
     * @param $order_params 支付订单参数
     * @return mixed
     */
    public function pay($payType, $order_params);

    /**
     * query an order
     * @return mixed
     */
    public function query();

    /**
     * refund an order
     * @return mixed
     */
    public function refund();

    /**
     * say yes or no to servers
     * @return mixed
     */
    public function echoSuccess();

    /**
     * @param $data
     * @return mixed
     */
    public function verify($data);
}