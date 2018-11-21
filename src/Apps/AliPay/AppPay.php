<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/15
 * Time: 18:07
 */

namespace jikesen\jkPay\Apps\AliPay;


use jikesen\jkPay\Convention\ConventionPayInterface;
use jikesen\jkPay\Utils\AliTool;
use jikesen\jkPay\Utils\Config;
use Symfony\Component\HttpFoundation\Response;

class AppPay implements ConventionPayInterface
{
    /**
     * @var string 接口方法
     */
    protected $method = 'alipay.trade.app.pay';
    /**
     * @var string 销售产品码
     */
    protected $product_code = 'QUICK_MSECURITY_PAY';

    /**
     * @inheritDoc
     * @throws \jikesen\jkPay\Exceptions\Exception
     */
    public function pay($param)
    {
        //组装签名参数
        $param['method']                      = $this->method;
        $param['biz_content']                 = json_decode($param['biz_content'], true);
        $param['biz_content']['product_code'] = $this->product_code;
        $param['biz_content']                 = json_encode($param['biz_content']);

        //签名
        $t = new AliTool();
        $param['sign'] =  $t->generateSign($param);

        return Response::create(http_build_query($param));
    }

}