<?php
/**
 * Created by PhpStorm.
 * User: jkSen
 * Date: 2018/11/19
 * Time: 14:11
 */

namespace jikesen\jkPay\Apps\AliPay;


use GuzzleHttp\Client;
use http\Env\Response;
use jikesen\jkPay\Convention\ConventionPayInterface;
use jikesen\jkPay\Utils\AliTool;

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

    public $trade_pay = 'https://openapi.alipay.com/gateway.do';

    /**
     * @inheritDoc
     * @throws \jikesen\jkPay\Exceptions\Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function pay($param)
    {
        $param['method']                      = $this->method;
        $param['biz_content']                 = json_decode($param['biz_content'], true);
        $param['biz_content']['product_code'] = $this->product_code;
        $param['biz_content']                 = json_encode($param['biz_content']);

        // make sign
        $param['sign'] = AliTool::GenerateSign($param);
        $preString     = AliTool::GetSignContentUrlencode($param);
        $url           = $this->trade_pay . "?" . $preString;
        //如果客户端集成了自己的页面只需要二维码 选填参数qr_pay_mode 可以切入iframe 来做
        $client = new Client();
        return \Symfony\Component\HttpFoundation\Response::create($client->send($url));
    }
}