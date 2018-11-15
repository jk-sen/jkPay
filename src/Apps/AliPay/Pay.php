<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/15
 * Time: 17:51
 */

namespace jikesen\jkPay\Apps\AliPay;


use jikesen\jkPay\Convention\ConventionAppInterface;

class Pay implements ConventionAppInterface
{
    /**
     * @var string 统一支付网关
     */
    public $trade_pay = 'https://openapi.alipay.com/gateway.do';

    /**
     * Pay constructor.
     * @param array $config 传入支付宝的支付配置文件
     */
    public function __construct(array $config)
    {
        $config = [
            'app_id'      => $config['app_id'],
            'method'      => $this->trade_pay,
            'format'      => 'JSON',
            'charset'     => 'utf-8',
            'sign_type'   => 'RSA2',
            'sign'        => '',
            'timestamp'   => date("Y-m-d H:i:s"),
            'version'     => '1.0',
            'notify_url'  => $config['notify_url'],
            'biz_content' => '',
        ];
    }

    /**
     * @inheritDoc
     */
    public function pay()
    {
        echo 'zhb pay';
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