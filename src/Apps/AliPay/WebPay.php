<?php
/**
 * Created by PhpStorm.
 * User: jkSen
 * Date: 2018/11/19
 * Time: 14:11
 */

namespace jikesen\jkPay\Apps\AliPay;


use jikesen\jkPay\Utils\AliTool;
use Symfony\Component\HttpFoundation\Response;
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
     * @throws \jikesen\jkPay\Exceptions\Exception
     */
    public function pay($param, $gatWayUrl)
    {
        // Assembly signature parameter
        $param['method']                      = $this->method;
        $param['biz_content']                 = json_decode($param['biz_content'], true);
        $param['biz_content']['product_code'] = $this->product_code;
        $param['biz_content']                 = json_encode($param['biz_content']);

        $t             = new AliTool();
        $param['sign'] = $t->generateSign($param);

        $Html = $this->buildRequestForm($param, $gatWayUrl);
        return Response::create($Html);
    }

    /**
     * Doc：build http request form
     * Author：JKSen
     * Date: 2019-04-21  18:10
     *
     * @param        $param
     * @param        $gatWayUrl
     * @param string $method
     *
     * @return string
     */
    public function buildRequestForm($param, $gatWayUrl, $method = 'POST')
    {

        if ($method == 'GET') {
            echo 'get';
        }

        $Html = "<form id='aliPaySubmit' name='aliPaySubmit' action='" . $gatWayUrl . "?charset=" . $param['charset'] . "' method='{$method}'>";
        foreach ($param as $key => $val) {
            $val  = str_replace("'", '&apos;', $val);
            $Html .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $Html .= "<input type='submit' value='ok' style='display:none;'></form>";
        $Html .= "<script>document.forms['aliPaySubmit'].submit();</script>";

        return $Html;
    }
}