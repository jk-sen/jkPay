<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/15
 * Time: 17:45
 */
require_once './vendor/autoload.php';

use jikesen\jkPay\Pay;

echo Pay::AliPay([])->pay() . PHP_EOL;
echo Pay::WxPay([])->pay() . PHP_EOL;
