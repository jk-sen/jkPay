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
     * @param pay params $param
     * @return mixed|void
     * @throws \jikesen\jkPay\Exceptions\DataException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function pay($param)
    {
        $param['trade_type'] = $this->tradeType();

        try {
            $sign = WxTool::GenerateSign($param);
            $param['sign'] = $sign;
        } catch (ConfigException $e) {
            return ['err' => $e->getMessage()];
        }
        return $this->unifiedOrder(WxTool::ToXml($param));
    }

    public function tradeType()
    {
        return 'MWEB';
    }
}