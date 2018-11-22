<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/22
 * Time: 10:50
 */

namespace jikesen\jkPay\Apps\WxPay;

use jikesen\jkPay\Exceptions\ConfigException;
use jikesen\jkPay\Utils\WxTool;

/**
 * 微信H5支付
 * Class H5Pay
 * @package jikesen\jkPay\Apps\WxPay
 */
class H5Pay extends BasePay
{
    /**
     * @param 支付参数 $param
     * @return mixed|void
     */
    public function pay($param)
    {
        //微信生成签名
        $param['trade_type'] = $this->tradeType();

        $t = new WxTool();
        try {
            $sign = $t->generateSign($param);
        } catch (ConfigException $e) {
            echo $e->getMessage();
        }
        $param['sign'] = $sign;
        $res = $this->unifiedOrder($param);
        return is_array($res) ? $res : WxTool::FromXml($res);
    }

    public function tradeType()
    {
        return 'MWEB';
    }
}