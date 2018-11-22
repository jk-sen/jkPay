<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/22
 * Time: 10:58
 */

namespace jikesen\jkPay\Apps\WxPay;


use jikesen\jkPay\Convention\ConventionPayInterface;
use Symfony\Component\HttpFoundation\Request;

class BasePay implements ConventionPayInterface
{
    /**
     * 微信统一下单Url
     * @var string
     */
    protected $unifiedorder_url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';

    /**
     * 构造预支付
     * @param 支付参数 $param
     * @return mixed|void
     */
    public function pay($param)
    {
        // TODO: Implement pay() method.
    }

    /**
     * 生成微信预支付订单/统一下单支付
     */
    public function unifiedOrder($order_params)
    {
        return Request::create($this->unifiedorder_url,'POST',$order_params);
    }
}