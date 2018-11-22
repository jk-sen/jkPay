<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/15
 * Time: 17:51
 */

namespace jikesen\jkPay\Apps\WxPay;


use jikesen\jkPay\Convention\ConventionAppInterface;
use jikesen\jkPay\Convention\ConventionPayInterface;
use jikesen\jkPay\Convention\支付类型;
use jikesen\jkPay\Convention\支付订单参数;
use jikesen\jkPay\Utils\Config;
use jikesen\jkPay\Utils\WxTool;
use Symfony\Component\HttpFoundation\Request;

/**
 * @property  config
 */
class Pay implements ConventionAppInterface
{
    /**
     * 支付类型
     * @var string
     */
    public $pay_type = '';

    /**
     * @var null 预支付参数
     */
    protected $prepay = null;

    public function __construct($config)
    {
        $this->prepay  = [
            'appid'            => $config['appid'],
            'mch_id'           => $config['mch_id'],
            'nonce_str'        => WxTool::getNonceStr(),
            'sign'             => '',
            'trade_type'       => '',
            'notify_url'       => $config['notify_url'],
            'spbill_create_ip' => Request::createFromGlobals()->getClientIp() ?? '127.0.0.1',
        ];
        $cg            = Config::getInstance();
        $cg->sign_type = $config['sign_type'] ?? 'MD5';
        $cg->wx_key    = $config['wx_key'];
    }

    /**
     * @inheritDoc
     */
    public function verify()
    {
        // TODO: Implement verify() method.
    }

    /**
     * @param $payType
     * @param $platform_order_parameters
     * @return mixed
     */
    public function __call($payType, $platform_order_parameters)
    {
        return $this->pay($payType, $platform_order_parameters);
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
    public function pay($payType, $order_params)
    {
        $this->prepay = array_merge($order_params[0], $this->prepay);
        // 获取客户端调用类型 获取app 接口类 检测有没有该类
        $pay_class = __NAMESPACE__ . '\\' . ucfirst($payType) . 'Pay';
        //确定类存在
        if (!class_exists($pay_class)) {
            throw new AppNotExistException('类不存在');
        }
        $pay = new $pay_class;
        //确认继承关系检测实例
        if ($pay instanceof ConventionPayInterface) {
            if (!empty($this->prepay)) {
                return $pay->pay($this->prepay);
            }
        }

        throw new AppNotExistException("pay type {$payType} must be ConventionPayInterface 的实例");
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