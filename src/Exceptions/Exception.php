<?php
/**
 * Created by PhpStorm.
 * User: sen
 * Date: 2018/11/9
 * Time: 22:03
 */

namespace jikesen\jkPay\Exceptions;


use Throwable;

class Exception extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


}