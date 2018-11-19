<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/15
 * Time: 18:07
 */

namespace jikesen\jkPay\Apps\AliPay;


use jikesen\jkPay\Convention\ConventionPayInterface;
use jikesen\jkPay\Utils\Config;

class AppPay implements ConventionPayInterface
{
    /**
     * @var string 接口名称
     */
    protected $method = 'alipay.trade.app.pay';
    /**
     * @var string 销售产品码
     */
    protected $product_code = 'QUICK_MSECURITY_PAY';

    /**
     * @inheritDoc
     */
    public function pay($param)
    {
        //组装签名参数
        $param['method'] = $this->method;
        $param['biz_content'] = json_decode($param, true);
        $param['biz_content']['product_code'] = $this->product_code;
        $param['biz_content'] = json_encode($param['biz_content']);
        $_t = Config::getInstance();
        pre($_t->private_key);
    }

}