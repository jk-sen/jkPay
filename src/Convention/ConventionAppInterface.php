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
     * pay for an order
     * @return mixed
     */
    public function pay();

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
    public function callback();
}