<?php
/**
 * Created by PhpStorm.
 * User: jkSen
 * Date: 2018/11/15
 * Time: 17:51
 */

namespace jikesen\jkPay\Apps\WxPay;


use jikesen\jkPay\Convention\ConventionAppInterface;
use jikesen\jkPay\Convention\ConventionPayInterface;
use jikesen\jkPay\Convention\SignException;
use jikesen\jkPay\Exceptions\AppNotExistException;
use jikesen\jkPay\Exceptions\DataException;
use jikesen\jkPay\Utils\Config;
use jikesen\jkPay\Utils\WxTool;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @property  config
 */
class Pay implements ConventionAppInterface
{
    /**
     * pay type
     * @var string
     */
    public $pay_type = '';

    /**
     * @var null Prepayment parameter
     */
    protected $prepay = null;

    /**
     * Pay constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->prepay = [
            'appid'            => $config['appid'],
            'mch_id'           => $config['mch_id'],
            'nonce_str'        => WxTool::GetNonceStr(),
            'sign'             => '',
            'trade_type'       => '',
            'notify_url'       => $config['notify_url'],
            'spbill_create_ip' => Request::createFromGlobals()->getClientIp() ? Request::createFromGlobals()->getClientIp() : '127.0.0.1',
        ];
        $cg = Config::getInstance();
        $cg->__set('sign_type', !empty($config['sign_type']) ? $config['sign_type'] : 'MD5');
        $cg->__set('wx_key', $config['wx_key']);
    }

    /**
     * @param null $data
     * @return mixed|void
     * @throws DataException
     * @throws \jikesen\jkPay\Exceptions\ConfigException
     * @throws SignException
     */
    public function verify($data = null)
    {
        $data = $data != null ? $data : Request::createFromGlobals()->getContent();

        if ($data == null) {
            throw new DataException('WeChat returns an XML data error');
        }

        // change xml data
        if (!is_array($data)) {
            $data = WxTool::FromXml($data);
        }

        // Verify the signature
        if (WxTool::GenerateSign($data) === $data['sign']) {
            return $data;
        }
        throw new SignException('WeChat returns a data signature validation error');
    }

    /**
     * @param $payType
     * @param $platform_order_parameters
     * @return mixed
     * @throws AppNotExistException
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
     * @throws AppNotExistException
     */
    public function pay($payType, $order_params)
    {
        $this->prepay = array_merge($order_params[0], $this->prepay);

        // Gets the client call type gets the app interface class to detect if there is a class
        $pay_class = __NAMESPACE__ . '\\' . ucfirst($payType) . 'Pay';

        // Make sure classes exist
        if (!class_exists($pay_class)) {
            throw new AppNotExistException('Call a class that does not exist');
        }

        // Verify the inheritance relationship detection instance
        $pay = new $pay_class;
        if ($pay instanceof ConventionPayInterface) {
            if (!empty($this->prepay)) {
                return $pay->pay($this->prepay);
            }
        }

        throw new AppNotExistException("pay type {$payType} must be ConventionPayInterface‘s Instance");
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
     * @throws DataException
     */
    public function echoSuccess()
    {
        $response = new Response(
            WxTool::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']),
            200,
            ['Content-Type' => 'application/xml']);
        return $response->send()->getContent();
    }
}