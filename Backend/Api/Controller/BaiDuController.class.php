<?php
/** .-------------------------------------------------------------------
 * |  Github: https://github.com/Tinywan
 * |  Blog: http://www.cnblogs.com/Tinywan
 * |-------------------------------------------------------------------
 * |  Author: Tinywan
 * |  Date: 2017/2/6
 * |  Time: 14:16
 * |  Mail: Overcome.wan@Gmail.com
 * |  Created by PhpStorm.
 * '-------------------------------------------------------------------*/

namespace Api\Controller;

/**
 * 百度API调用
 * http://apistore.baidu.com/
 */
class BaiDuController
{
    public function index()
    {
        echo __METHOD__;
    }

    public static function baiDuRequestUrl($url)
    {
        $header = ['apikey:cbbaa61823ce797038df761b3e947861'];
        // 添加apikey到header
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        return $res;
    }

    /**
     * 城市交通查询
     */
    public function base()
    {
        $id = "wutaishan";
        $url = "http://apis.baidu.com/apistore/attractions/spot?id=" . $id . "&output=json";
        $res = self::baiDuRequestUrl($url);
        var_dump(json_decode($res, true));
    }

    public function baiduBus()
    {
        $url = 'http://apis.baidu.com/jundie/plate_number_ocr/place_number_ocr?format=json&pic_url=http%3A%2F%2Fwww.longyao.cc%2Fuserfiles%2Fimages%2F201203131542.jpg';
        $res = self::baiDuRequestUrl($url);
        var_dump(json_decode($res, true));
    }

    /**
     * 获取签名
     * appId会在请求中作为一个应用标识参与接口请求的参数传递，appSecret 将作为唯一不需要参数传递,但是作为加密的参数
     */
    public function getSign()
    {
        $appId = 13669361192;
        $appSecret = 'r5e2t85tyu142u665698fzu';
        $allParam = [
            'appid' => $appId,
            'method' => 'createPushFlowAddress',
            'serviceArea' => 'A',
            'authKeyStatus' => 0,
            'appName' => 'live',
            'domainName' => 'tinywan.amai8.com',
        ];
        // 1. 对加密数组进行字典排序
        foreach ($allParam as $key => $value) {
            $sortParam[$key] = $key;
        }
        // 2. 字典排序的作用就是防止因为参数顺序不一致而导致下面拼接加密不同
        sort($sortParam);
        // 3. 将Key和Value拼接
        $str = "";
        foreach ($sortParam as $k => $v) {
            $str = $str . $sortParam[$k] . $allParam[$v];
        }
        //3.将appSecret作为拼接字符串的后缀,形成最后的字符串
        $finalStr = $str . $appSecret;
        //4. 通过sha1加密,转化为大写大写获得签名
        $sign = strtoupper(sha1($finalStr));
        echo $sign;
    }

    public function getSign2()
    {
        $appid = 13669361192;
        $method = 'createPushFlowAddress';
        $serviceArea = 'A';
        $authKeyStatus = 0;
        $appName = 'live';
        $domainName = 'tinywan.amai8.com';     #客户的访问域名
        $appsecret = 'r5e2t85tyu142u665698fzu';
        $sign = sha1("appName{$appName}appid{$appid}authKeyStatus{$authKeyStatus}domainName{$domainName}method{$method}serviceArea{$serviceArea}{$appsecret}");
        var_dump(strtoupper($sign));
    }
}