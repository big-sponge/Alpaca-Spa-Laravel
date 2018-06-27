<?php

/**
 * ssl处理
 * @author ChengCheng
 * @date 2017-04-12 08:55:39
 * */
class AlpacaSSL
{
    // 签名证书路径
    const SDK_SIGN_CERT_PATH = __DIR__ . "/../certs/1010shuju.pfx";

    // 签名证书密码
    const SDK_SIGN_CERT_PWD = '1010shuju';

    // 验签证书路径（请配到文件夹，不要配到具体文件）
    const SDK_VERIFY_CERT_DIR = __DIR__ . '/../certs/';

    //定义单例
    private static $instance = null;

    /**
     * 创建单例模型
     * @return static
     */
    public static function model()
    {
        if (!self::$instance) {
            self::$instance = new static;
        }
        return self::$instance;
    }

    /**
     * 私钥签名
     * @param  $order
     * @return mixed
     */
    public function sign($order)
    {
        //默认参数
        $params = array(
            'certId' => '****',//证书ID
        );

        //组织参数
        foreach ($order as $key => $value) {
            $params[$key] = $value;
        }

        //转换成key=value的串,并且计算sha1
        $params_string = $this->coverParamsToString($params);

        //获取签名证书 - 结果在 $certs"pkey"]里面
        openssl_pkcs12_read(file_get_contents(self::SDK_SIGN_CERT_PATH), $certs, self::SDK_SIGN_CERT_PWD);

        //签名 - 结果在 $signature 里面
        openssl_sign(sha1($params_string, false), $signature, $certs["pkey"], OPENSSL_ALGO_SHA1);

        //添加签名
        $params["signature"] = base64_encode($signature);

        //返回结果
        return $params;
    }

    /**
     * 公钥验证签名
     * @param $params
     * @return int
     */
    public function verify($params)
    {
        //公钥 - 获取证书
        $x509data = file_get_contents(self::SDK_VERIFY_CERT_DIR. '1010shuju.pem');

        //验证参数
        openssl_x509_read($x509data);
        $cert_data = openssl_x509_parse($x509data);
        $cert_id   = $cert_data['serialNumber'];

        //公钥
        $public_key = $x509data;

        //签名串
        $signature_str = $params['signature'];
        unset($params['signature']);
        $params_str     = $this->coverParamsToString($params);
        $signature      = base64_decode($signature_str);
        $params_sha1x16 = sha1($params_str, false);
        $isSuccess      = openssl_verify($params_sha1x16, $signature, $public_key, OPENSSL_ALGO_SHA1);
        return $isSuccess;
    }

    /**
     * 公钥加密
     * @param  $params
     * @return mixed
     */
    public function encrypt($params)
    {

        //转换成key=value的串,并且计算sha1
        $params_string = $this->coverParamsToString($params);

        //公钥 - 获取证书
        $public_key = file_get_contents(self::SDK_VERIFY_CERT_DIR. '1010shuju.pem');

        //公钥加密
        openssl_public_encrypt($params_string,$data,$public_key);

        //返回结果
        return base64_encode($data);
    }

    /**
     * 私钥解密
     * @param  $params
     * @return mixed
     */
    public function decrypt($params)
    {
        //获取数据
        $string = $params['data'];

        //获取签名证书 - 结果在 $certs"pkey"]里面
        openssl_pkcs12_read(file_get_contents(self::SDK_SIGN_CERT_PATH), $certs, self::SDK_SIGN_CERT_PWD);

        //私钥解密 - 结果在 $data 里面
        openssl_private_decrypt(base64_decode($string),$data,$certs["pkey"]);

        //返回结果
        return $data;
    }

    /**
     * 数组 排序后转化为字体串
     * @param array $params
     * @return string
     */
    private function coverParamsToString($params)
    {
        return json_encode($params,JSON_UNESCAPED_UNICODE);
    }
}