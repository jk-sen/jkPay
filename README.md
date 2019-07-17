# jkPay
集合微信支付宝支付

[![Build Status](https://travis-ci.org/michaelliao/openweixin.svg?branch=master)](https://travis-ci.org/michaelliao/openweixin)

#### 安装指南
```
composer require jikesen/jkpay dev-master --prefer-source

```
### 微信开发指引

##### 微信程序支付文档
|支付类型：|JSAPI| JSSDK|小程序|
|-----: |:-----: |:------:| :-----:|
|使用场景：|H5商城在微信内打开 | http|https|
|是否需要openid：|是|是|是|
|请求协议：|http | http|https|
|安全支付目录：|有|有|无|
|授权回调域名：|有|有|无|
|支付回调：|有|success|complete、fail、success|
##### 以上文档调起参数 五个字段参与签名(区分大小写)：
```angular2html
    appId,
    nonceStr,
    package,
    signType,
    timeStamp
```

[1]: https://mp.weixin.qq.com/ "微信公众平台"
[2]: https://open.weixin.qq.com/ "微信开放平台"
[3]: https://pay.weixin.qq.com/ "微信商户平台"
[4]: https://github.com/guzzle/guzzle/issues/1935 "guzzlehttp_curl erron "
[5]: http://www.3mu.me/php%E7%9A%84curl%E9%80%89%E9%A1%B9curlopt_ssl_verifypeer%E8%AF%A6%E8%A7%A3/ "curl pem"

##### 微信公众平台
打开 [微信公众平台][1] 
```angular2html
    
```

##### 微信开放平台
打开 [微信开放平台][2] 
```angular2html 
         
```

##### 微信商户平台 JSAPI支付
打开 [微信商户平台][3]
```angular2html
    设置JSAPI支付支付目录，设置路径：商户平台 --> 产品中心--> 开发配置
```

##### 获取openid
```angular2html
    需要在公众平台设置获取openid的域名
```
##### 设置授权域名
```angular2html
    
```
##### 如果使用guzzlehttp Http请求组件中 如果你的curl版本 > 7.55 
解决方案 [guzzlehttp_curl erron ][4]
curl请求证书 [curl pem][5]




