<?php
/**
 * Created by PhpStorm.
 * User: jkSen
 * Date: 2018/11/19
 * Time: 14:11
 */

namespace jikesen\jkPay\Apps\AliPay;


use jikesen\jkPay\Convention\ConventionPayInterface;

class WebPay implements ConventionPayInterface
{
    /**
     * @var string Interface methods
     */
    protected $method = 'alipay.trade.page.pay';

    /**
     * @var string Sales product code
     */
    protected $product_code = 'FAST_INSTANT_TRADE_PAY';

    /**
     * @inheritDoc
     */
    public function pay($param)
    {
        return 'web';
    }
}