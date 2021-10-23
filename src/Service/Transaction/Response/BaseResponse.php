<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/22
 * Time: 下午6:10
 */

namespace Lmh\Payeco\Service\Transaction\Response;


use Exception;
use Illuminate\Support\Arr;
use Lmh\Payeco\Support\RSASigner;
use Lmh\Payeco\Support\SignatureFactory;
use Lmh\Payeco\Support\Xml;

class BaseResponse
{
    /**
     * @var string 通讯协议版本号
     */
    protected $version = '2.0.0';
    /**
     * @var string 商户ID
     */
    protected $merchantId;
    /**
     * 先取head中的retCode码，如retCode码不为’0000’,则此交易失败，无需取body部分；报文格式如下：
     * @var string
     */
    protected $retCode;
    /**
     * @var string
     */
    protected $retMsg;
    /**
     * @var string
     */
    protected $responsePlainText;
    /**
     * @var array
     */
    protected $responseData;

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getMerchantId(): string
    {
        return $this->merchantId;
    }

    /**
     * @param string $merchantId
     */
    public function setMerchantId(string $merchantId): void
    {
        $this->merchantId = $merchantId;
    }


    /**
     * @return string
     */
    public function getResponsePlainText(): string
    {
        return $this->responsePlainText;
    }


    public function handle(string $message)
    {
        $this->responsePlainText = $message;
        $this->responseData = Xml::parse(str_replace('encoding="GBK"', 'encoding="UTF-8"', $this->responsePlainText));
        $head = $this->responseData['head'] ?? [];
        $this->retCode = Arr::get($head, 'retCode');
        $this->retMsg = Arr::get($head, 'retMsg');
    }


    /**
     * 验证签名
     * @param array $plain
     * @param string $sign
     * @param string $publicKey
     * @throws Exception
     * @author lmh
     */
    protected function signVerify(array $plain, string $sign, string $publicKey)
    {
        $sign = str_replace(" ", "+", $sign);
        SignatureFactory::setSigner(new RSASigner('', '', '', '', $publicKey));
        $plainText = http_build_query($plain);
        SignatureFactory::getSigner()->verify($plainText, $sign);
    }
}