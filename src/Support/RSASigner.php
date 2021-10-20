<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/18
 * Time: 下午3:11
 */

namespace Lmh\Payeco\Support;


use Exception;

class RSASigner
{
    /**
     * @var string 商户私钥内容
     */
    private $keyContent;
    /**
     * @var string  商户公钥内容
     */
    private $certContent;
    /**
     * @var string 平台公钥内容
     */
    private $platformCertContent;

    /**
     * RSASigner constructor.
     * @param string $filepath
     * @param string $password
     * @param string $keyContent
     * @param string $certificateFilename
     * @param string $certContent
     * @param string $platformCertContent
     */
    public function __construct(string $filepath = '', string $password = '', string $keyContent = '', string $certificateFilename = '', string $certContent = '', string $platformCertContent = '')
    {
        if ($certContent) {
            $this->certContent = $certContent;
        } else if ($certificateFilename) {
            $this->certContent = file_get_contents($certificateFilename);
        }
        if ($keyContent) {
            $this->keyContent = $keyContent;
        } else if ($filepath) {
            $pkcs12 = file_get_contents($filepath);
            openssl_pkcs12_read($pkcs12, $p12cert, $password);
            $this->keyContent = $p12cert["pkey"];
            $this->certContent = $p12cert['cert'];
        }
        $this->platformCertContent = $platformCertContent;
    }

    /**
     * 生成签名
     * @param string $plainText
     * @return string
     * @throws Exception
     */
    public function sign(string $plainText): string
    {
        $signature = "";
        try {
            openssl_sign($plainText, $signature, $this->keyContent, OPENSSL_ALGO_MD5);
        } catch (Exception $e) {
            throw new Exception('签名证书配置错误');
        }
        return base64_encode($signature);
    }


    /**
     * 验证签名
     * @param string $plainText
     * @param string $signature
     * @return int
     * @throws Exception
     */
    public function verify(string $plainText, string $signature): int
    {
        $signature = base64_decode($signature);
        if (!$this->certContent) {
            throw new Exception('签名证书配置错误');
        }
        return openssl_verify($plainText, $signature, $this->certContent, OPENSSL_ALGO_MD5);
    }

    /**
     * 公钥加密
     * @param $data
     * @return string
     * @throws Exception
     * @author lmh
     */
    public function encrypt($data): string
    {
        $encrypted = '';
        if (!$this->platformCertContent) {
            throw new Exception('平台证书配置错误');
        }
        openssl_public_encrypt($data, $encrypted, $this->platformCertContent, OPENSSL_PKCS1_PADDING);
        return base64_encode($encrypted);
    }

    /**
     * 私钥解密
     * @param $data
     * @return string
     * @throws Exception
     * @author lmh
     */
    public function decrypt($data): string
    {
        $decrypted = '';
        $data = base64_decode($data);
        if (!$this->keyContent) {
            throw new Exception('签名证书配置错误');
        }
        openssl_private_decrypt($data, $decrypted, $this->keyContent, OPENSSL_PKCS1_PADDING);
        return $decrypted;
    }
}