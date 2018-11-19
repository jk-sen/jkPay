<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/19
 * Time: 14:11
 */

namespace jikesen\jkPay\Apps\AliPay;


use jikesen\jkPay\Convention\ConventionPayInterface;
use jikesen\jkPay\Convention\支付参数;

class WebPay implements ConventionPayInterface
{
    protected $method = 'alipay.trade.page.pay';

    /**
     * @inheritDoc
     */
    public function pay($param)
    {
        echo 'web 支付';
        pre($param);
        return 'web';
    }
}