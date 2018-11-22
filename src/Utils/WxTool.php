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
    public $signType = '';

    /**
     *
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return string
     */
    public static function getNonceStr($length = 32): string
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str   = "";
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
    public function generateSign($params): string
    {
        $c        = Config::getInstance();
        $signType = $c->__get('sign_type');
        $wxkey    = $c->__get('wx_key');
        if (is_null($wxkey)) {
            throw new ConfigException("微信key 不存在，请检查您的配置");
        }
        //签名步骤一：按字典序排序参数
        ksort($params);
        $string = $this->ToUrlParams($params);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . $wxkey;
        //签名步骤三：MD5加密或者HMAC-SHA256
        if ($signType == "MD5") {
            $string = md5($string);
        } else if ($signType == "HMAC-SHA256") {
            $string = hash_hmac("sha256", $string, $wxkey);
        } else {
            throw new ConfigException("签名类型不支持！");
        }

        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }


    /**
     * 格式化参数格式化成url参数
     */
    public function ToUrlParams($param): string
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
    public static function ToXml($param): string
    {
        if (!is_array($param) || count($param) <= 0) {
            throw new DataException("数组数据异常！");
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
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     * @throws DataException
     */
    public static function FromXml($xml): array
    {

        $xmlObj = simplexml_load_string($xml);
        return $xmlObj ?
            $arr = array(
                'return_code'   => (string) $xmlObj->return_code,
                'return_msg'    => (string) $xmlObj->return_msg,
                'appid'         => (string) $xmlObj->appid,
                'mch_id'        => (string) $xmlObj->mch_id,
                'nonce_str'     => (string) $xmlObj->nonce_str,
                'sign'          => (string) $xmlObj->sign,
                'result_code'   => (string) $xmlObj->result_code,
                'prepay_id'     => (string) $xmlObj->prepay_id,
                'trade_type'    => (string) $xmlObj->trade_type,
                'mweb_url'      => (string) $xmlObj->mweb_url,
                'agent_id'      => (string) $xmlObj->agent_id,
                'code_url'      => (string) $xmlObj->code_url,
            ) : false;

        /*if (!$xml) {
            throw new DataException('Convert To Array Error! Invalid Xml!');
        }
        file_put_contents('a.txt',$xml);
        libxml_disable_entity_loader(true);

        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA), JSON_UNESCAPED_UNICODE), true);*/
    }
}