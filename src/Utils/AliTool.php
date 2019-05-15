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
    public function generateSign($params)
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
    protected function getSignContent($params)
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
    protected function checkEmpty($value)
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

    static function pushdtk($contents, $atOne = [], $type = '')
    {
        ignore_user_abort(TRUE);
        if($atOne === TRUE){
            $isAtAll = TRUE;
            $atMobiles = [];
        }else{
            $isAtAll = FALSE;
            $atMobiles = is_array($atOne) ? $atOne : (is_numeric($atOne) ? [$atOne] : []);
        }
        $jsonBody = json_encode([
                                    'msgtype'   => 'text',
                                    'text'      => [
                                        'content'   => is_string($contents) ? $contents : json_encode([$contents])
                                    ],
                                    'at'        => [
                                        'atMobiles' => $atMobiles,
                                        'isAtAll'   => $isAtAll
                                    ],
                                ]);
        $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) ';
        $ua .= 'Chrome/64.0.3282.186 Safari/537.36';
        $accessToken = '494707ae07233c415aa8723f7d4d4f1511e05f55a24449259297ad3ad7a58563';
        if($type == 'ssh'){
            $accessToken = 'e9e905ba690218311fbc4c73103e5597d6a8cbbd50b5405cf8c84fbd4b93236a';
        }
        if($type == 'jk'){
            $accessToken = '5d3893201d2b5dde93b2b66a481066378d789d57d1611304f27e33b9738ad8f2';
        }
        $url = 'https://oapi.dingtalk.com/robot/send?access_token=' . $accessToken;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOSIGNAL, true);// 注意，毫秒超时一定要设置这个
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 300);// 超时时间(毫秒)
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['content-type: application/json']);
        $output = curl_exec($ch);
        if($output === FALSE || curl_errno($ch)){
            return 'CURL Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $output;
    }
}