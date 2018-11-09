<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/9
 * Time: 10:57
 */

namespace jikesen\jkPay\Convention;


interface GateWayInterface
{
    public function pay();
}