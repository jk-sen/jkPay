<?php /** @noinspection ALL */

/**
 * Created by PhpStorm.
 * User: sen
 * Date: 2018/11/9
 * Time: 22:44
 */

namespace jikesen\jkPay\Utils;

use jikesen\jkPay\Exceptions\ConfigException;
use jikesen\jkPay\Exceptions\Exception;

/**
 * 支付宝签名 等工具
 * Class ZfbTool
 * @package jikesen\jkPay\Tools
 */
class AliTool
{
    public $charset;

    private $fileCharset = "UTF-8";

    /**
     * @param $params
     * @return string
     * @throws Exception
     */
    public function generateSign($params): string
    {
        $privateKey = Config::getInstance()->private_key;

        if(!isset($privateKey)){
            throw new ConfigException('the private key is must be set! check your pay config');
        }

        if (is_null($privateKey)) {
            throw new Exception('私钥不能为空');
        }

        //暂不支持配置文件
        $_privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($privateKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";

        //原始未签名字符串
        $_params     = $this->getSignContent($params);

        openssl_sign($_params, $sign, $_privateKey, OPENSSL_ALGO_SHA256);

        $sign = base64_encode($sign);

        return $sign;
    }

    /**
     * @param $params
     * @return string
     */
    protected function getSignContent($params): string
    {
        ksort($params);

        $stringToBeSigned = "";

        $i = 0;
        foreach ($params as $k => $v) {
            if (false === self::checkEmpty($v) && "@" != substr($v, 0, 1)) {

                // 转换成目标字符集
                $v = $this->characet($v, Config::getInstance()->charset);

                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }


    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *    if is null , return true;
     **/
    protected function checkEmpty($value): bool
    {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;

        return false;
    }

    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    protected function characet($data, $targetCharset)
    {
        if (!empty($data)) {
            $fileType = $this->fileCharset;
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }
        return $data;
    }
}