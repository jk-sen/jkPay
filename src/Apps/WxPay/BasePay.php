<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/22
 * Time: 10:58
 */

namespace jikesen\jkPay\Apps\WxPay;


use GuzzleHttp\Client;
use jikesen\jkPay\Convention\ConventionPayInterface;
use jikesen\jkPay\Utils\WxTool;

class BasePay implements ConventionPayInterface
{
    /**
     * WeChat unifiedorder Url
     * @var string
     */
    protected $unifiedorder_url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';

    /**
     * build pay
     * @param  $param
     * @return mixed|void
     */
    public function pay($param)
    {
        // TODO: Implement pay() method.
    }

    /**
     * @param $order_params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \jikesen\jkPay\Exceptions\DataException
     */
    protected function unifiedOrder($order_params)
    {
        $client = new Client();
        $request = new \GuzzleHttp\Psr7\Request('POST', $this->unifiedorder_url
            , ['Content-Type' => 'text/xml; charset=UTF8'], $order_params);

        $res = $client->send($request);
        return is_array($res) ? $res : WxTool::FromXml($res->getBody()->getContents());
    }
}