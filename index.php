<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/15
 * Time: 17:45
 */
require_once './vendor/autoload.php';
require_once './src/Utils/common.inc';

use jikesen\jkPay\Pay;

//商户订单参数
$order = [
    'body' => '测试商品',
    'subject' => '测试商品',
    'out_trade_no' => '123456456789',
    'total_amount' => '10',//单位为元
    'return_url' => '11',
];

//支付配置参数
$config = [
    'private_key' => 'si',
    'public_key' => 'go',
    'app_id'     => 1,
    'notify_url' => 2,
];
Pay::AliPay($config)->app($order);
