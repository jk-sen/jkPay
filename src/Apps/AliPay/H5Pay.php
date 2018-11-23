<?php
/**
 * Created by PhpStorm.
 * User: jkSen
 * Date: 2018/11/23
 * Time: 16:22
 */

namespace jikesen\jkPay\Apps\AliPay;


use jikesen\jkPay\Convention\ConventionPayInterface;

class H5Pay implements ConventionPayInterface
{
    /**
     * @var string Interface methods
     */
    protected $method = 'alipay.trade.wap.pay';

    /**
     * @var string Sales product code
     */
    protected $product_code = 'QUICK_WAP_WAY';

    /**
     * @inheritDoc
     */
    public function pay($param)
    {
        // TODO: Implement pay() method.
    }

}