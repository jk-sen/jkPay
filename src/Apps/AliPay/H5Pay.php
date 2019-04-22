<?php
/**
 * Created by PhpStorm.
 * User: jkSen
 * Date: 2018/11/23
 * Time: 16:22
 */

namespace jikesen\jkPay\Apps\AliPay;


use jikesen\jkPay\Convention\ConventionPayInterface;
use jikesen\jkPay\Utils\AliTool;
use Symfony\Component\HttpFoundation\Response;

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

        $Html          = $this->buildRequestForm($param, $gatWayUrl);
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

    /**
     * Doc：检测是否存在空值
     * Author：JKSen
     * Date: 2019-04-21  18:01
     *
     * @param $value
     *
     * @return bool
     */
    protected function checkEmpty($value)
    {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;

        return false;
    }
}