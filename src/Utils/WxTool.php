<?php
/**
 * Created by PhpStorm.
 * User: sen
 * Date: 2018/11/9
 * Time: 22:44
 */

namespace jikesen\jkPay\Utils;


use jikesen\jkPay\Exceptions\ConfigException;
use jikesen\jkPay\Exceptions\DataException;

class WxTool
{
    /**
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return string
     */

    public static function GetNonceStr($length = 32)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $str   = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 微信签名
     * @param $params
     * @return string
     * @throws ConfigException
     */

    public static function GenerateSign($params)
    {
        $c        = Config::getInstance();
        $signType = $c->__get('sign_type');
        $wxkey    = $c->__get('wx_key');
        if (is_null($wxkey)) {
            throw new ConfigException("微信key 不存在，请检查您的配置");
        }
        //step 1: ksrot
        ksort($params);
        $string = self::ToUrlParams($params);

        //step 2：add key after string
        $string = $string . "&key=" . $wxkey;

        //step 3：MD5 Encryption or HMAC-SHA256
        if ($signType == 'MD5') {
            $string = md5($string);
        } else if ($signType == 'HMAC-SHA256') {
            $string = hash_hmac('sha256', $string, $wxkey);
        } else {
            throw new ConfigException("签名类型不支持！");
        }

        //step 4：All characters are capitalized
        $result = strtoupper($string);
        return $result;
    }


    /**
     * Format parameters into url parameters
     * @param $param
     * @return string
     */

    public static function ToUrlParams($param)
    {
        $buff = "";
        foreach ($param as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }


    /**
     * @param $param
     * @return string
     * @throws DataException
     */
    public static function ToXml($param)
    {
        if (!is_array($param) || count($param) <= 0) {
            throw new DataException("Array data exception");
        }

        $xml = "<xml>";
        foreach ($param as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * @param $xml
     * @return array
     * @throws DataException
     */
    public static function FromXml($xml)
    {
        if (!$xml) {
            throw new DataException('Convert To Array Error! Invalid Xml!');
        }
        libxml_disable_entity_loader(true);

        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA), JSON_UNESCAPED_UNICODE), true);
    }
}