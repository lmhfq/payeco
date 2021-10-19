<?php
declare(strict_types=1);

namespace Lmh\Payeco;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use Lmh\Payeco\Request\BaseRequest;
use Lmh\Payeco\Response\BaseResponse;
use Lmh\Payeco\Support\AES;
use Lmh\Payeco\Support\RSASigner;
use Lmh\Payeco\Support\ServiceContainer;
use Lmh\Payeco\Support\SignatureFactory;
use Psr\Log\LoggerInterface;

/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/18
 * Time: 下午2:04
 */
class EcoClient extends ServiceContainer
{
    public function execute(BaseRequest $request, BaseResponse $response): BaseResponse
    {

        SignatureFactory::setSigner(new RSASigner(
            $this->offsetGet("config")['keystoreFilename'],
            $this->offsetGet("config")['keystorePassword'],
            $this->offsetGet("config")['keyContent'],
            $this->offsetGet("config")['certificateFilename'],
            $this->offsetGet("config")['certContent']
        ));
        $request->handle();
        /**
         * @var LoggerInterface $logger
         */
        $logger = $this->offsetGet("config")['logger'] ?? null;
        if ($logger instanceof LoggerInterface && $this->offsetGet("config")['debug']) {
            $logger->debug("请求原文：" . $request->getRequestPlainText());
        }
        //商户随机生成key，用3des对a进行加密，得到b；
        $key = Str::random(24);
        $aes = new AES($key);
        $reqBodyEnc = $aes->encrypt($request->getRequestPlainText());
        //商户使用易联公钥加密key，得到c；
        $reqKeyEnc =  SignatureFactory::getSigner()->encrypt(base64_encode($key),  $this->offsetGet("config")['platformCertContent']);
        //商户将报文组合b|c
        $body = $reqBodyEnc . "|" . $reqKeyEnc;
        $result = $this->request($body);
        //$result = explode("|", $result);

        //$response->handle($result);
//        if ($logger instanceof LoggerInterface && $this->offsetGet("config")['debug']) {
//            $logger->debug("响应原文：" . $response->getResponsePlainText());
//        }
        return $response;
    }


    /**
     * @param string $data
     * @return string
     * @throws GuzzleException
     */
    private function request(string $data)
    {
        $client = new Client($this->offsetGet("config")['http']);
        $options = [
            'headers' => [
                'Accept'     => 'text/xml',
                'Content-type' => 'text/xml; charset=UTF8',
            ],
            'body' => $data,
            'verify' => false
        ];

        $response = $client->request('POST', '', $options);
        return $response->getBody()->getContents();
    }

    /**
     * 处理回调
     * @param string $message
     * @param string $signature

     */
    public function notify(string $message, string $signature, NtcBaseRequest $noticeRequest): NtcBaseRequest
    {
        SignatureFactory::setSigner(new RSASigner(
            $this->offsetGet("config")['keyContent'],
            $this->offsetGet("config")['certContent']
        ));
        $noticeRequest->handle($message, $signature);

        $logger = $this->offsetGet("logger");
        if ($this->offsetGet("config")['debug']) {
            $logger->debug("回调原文", [$noticeRequest->getPlainText()]);
        }
        return $noticeRequest;
    }
}