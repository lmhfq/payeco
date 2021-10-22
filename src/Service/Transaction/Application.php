<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/22
 * Time: 下午4:16
 */

namespace Lmh\Payeco\Service\Transaction;


use Lmh\Payeco\Service\Transaction\Request\BaseRequest;
use Lmh\Payeco\Service\Transaction\Response\BaseResponse;
use Lmh\Payeco\Support\ServiceContainer;

class Application extends ServiceContainer
{
    /**
     * 执行请求
     * @param BaseRequest $request
     * @param BaseResponse $response
     * @return BaseResponse
     * @author lmh
     */
    public function execute(BaseRequest $request, BaseResponse $response): BaseResponse
    {
        if (!$request->getMerchantId()) {
            $request->setMerchantId($this->offsetGet("config")['merchantId']);
        }
//        SignatureFactory::setSigner(new RSASigner(
//            $this->offsetGet("config")['keystoreFilename'],
//            $this->offsetGet("config")['keystorePassword'],
//            $this->offsetGet("config")['keyContent'],
//            $this->offsetGet("config")['certificateFilename'],
//            $this->offsetGet("config")['certContent'],
//            $this->offsetGet("config")['platformCertContent']
//        ));
        $request->handle();
        /**
         * @var LoggerInterface $logger
         */
        $logger = $this->offsetGet("config")['logger'] ?? null;
        if ($logger instanceof LoggerInterface && $this->offsetGet("config")['debug']) {
            $logger->debug("请求原文：" . $request->getRequestPlainText());
        }
        //商户随机生成key，用3des对a进行加密，得到b；
        $encodeKey = Str::random(24);
        $aes = new AES($encodeKey);
        $reqBodyEnc = $aes->encrypt($request->getRequestPlainText());
        //商户使用易联公钥加密key，得到c；
        $reqKeyEnc = SignatureFactory::getSigner()->encrypt(base64_encode($encodeKey));
        //商户将报文组合b|c
        $body = $reqBodyEnc . "|" . $reqKeyEnc;
        $result = $this->request($body);
        $result = explode("|", $result);
        $response->handle($result);
        if ($logger instanceof LoggerInterface && $this->offsetGet("config")['debug']) {
            $logger->debug("响应原文：" . $response->getResponsePlainText());
        }
        return $response;
    }
}