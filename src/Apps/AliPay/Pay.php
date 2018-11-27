<?php /** @noinspection PhpParamsInspection */

/**
 * Created by PhpStorm.
 * User: jkSen
 * Date: 2018/11/15
 * Time: 17:51
 */

namespace jikesen\jkPay\Apps\AliPay;


use GuzzleHttp\Psr7\Request;
use jikesen\jkPay\Convention\ConventionAppInterface;
use jikesen\jkPay\Convention\ConventionPayInterface;
use jikesen\jkPay\Exceptions\AppNotExistException;
use jikesen\jkPay\Utils\Config;

class Pay implements ConventionAppInterface
{
    /**
     * @var string 统一支付网关
     */
    public $trade_pay = 'https://openapi.alipay.com/gateway.do';

    /**
     * @var null 预支付参数
     */
    protected $prepay = null;

    /**
     * Pay constructor.
     * @param array $config 传入支付宝的支付配置文件
     */
    public function __construct(array $config)
    {
        $this->prepay    = [
            'app_id'      => $config['app_id'],
            'method'      => '', //不同的支付类型不同的方法
            'format'      => 'JSON',
            'charset'     => $config['charset'],
            'sign_type'   => 'RSA2',
            'sign'        => '',
            'timestamp'   => '2018-11-27 07:48:25',//date("Y-m-d H:i:s"),
            'version'     => '1.0',
            'notify_url'  => $config['notify_url'],
            'biz_content' => '',
        ];
        $cg              = Config::getInstance();
        $cg->private_key = $config['private_key'];
        $cg->public_key  = $config['public_key'];
        $cg->charset     = $config['charset'];
        $cg->return_url  = $config['return_url'];
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
     */
    public function refund()
    {
        // TODO: Implement refund() method.
    }

    /**
     * @param $payType
     * @param $order_params
     * @return mixed
     * @throws AppNotExistException
     */
    public function pay($payType, $order_params)
    {
        $order_params = $order_params[0];

        // Gets the client call type gets the app interface class to detect if there is a class
        $pay_class = __NAMESPACE__ . '\\' . ucfirst($payType) . 'Pay';

        // Make sure classes exist
        if (!class_exists($pay_class)) {
            throw new AppNotExistException('类不存在');
        }
        $this->prepay['return_url']  = Config::getInstance()->return_url ?? Config::getInstance()->return_url;
        $this->prepay['biz_content'] = json_encode($order_params);

        // Verify the inheritance relationship detection instance
        $pay = new $pay_class;
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
    public function verify($data)
    {
        // TODO: Implement verify() method.
    }

    /**
     * @inheritDoc
     */
    public function echoSuccess()
    {
        // TODO: Implement echoSuccess() method.
    }
}