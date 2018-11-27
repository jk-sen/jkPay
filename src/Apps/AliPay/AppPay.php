<?php
/**
 * Created by PhpStorm.
 * User: jkSen
 * Date: 2018/11/15
 * Time: 18:07
 */

namespace jikesen\jkPay\Apps\AliPay;


use jikesen\jkPay\Convention\ConventionPayInterface;
use jikesen\jkPay\Utils\AliTool;
use Symfony\Component\HttpFoundation\Response;

class AppPay implements ConventionPayInterface
{
    /**
     * @var string Interface methods
     */
    protected $method = 'alipay.trade.app.pay';

    /**
     * @var string Sales product code
     */
    protected $product_code = 'QUICK_MSECURITY_PAY';

    /**
     * @inheritDoc
     * @throws \jikesen\jkPay\Exceptions\Exception
     */
    public function pay($param)
    {
        // Assembly signature parameter
        $param['method']                      = $this->method;
        $param['biz_content']                 = json_decode($param['biz_content'], true);
        $param['biz_content']['product_code'] = $this->product_code;
        $param['biz_content']                 = json_encode($param['biz_content']);

        // make sign
        $param['sign'] =  AliTool::GenerateSign($param);

        return Response::create(http_build_query($param));
    }

}