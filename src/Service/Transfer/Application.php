<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/22
 * Time: 下午3:13
 */

namespace Lmh\Payeco\Service\Transfer;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use Lmh\Payeco\Service\Transfer\Request\BaseRequest;
use Lmh\Payeco\Service\Transfer\Response\BaseResponse;
use Lmh\Payeco\Support\AES;
use Lmh\Payeco\Support\RSASigner;
use Lmh\Payeco\Support\ServiceContainer;
use Lmh\Payeco\Support\SignatureFactory;
use Psr\Log\LoggerInterface;

class Application extends ServiceContainer
{
    /**
     * 执行请求
     * @param BaseRequest $request
     * @param BaseResponse $response
     * @return BaseResponse
     * @throws GuzzleException
     * @author lmh
     */
    public function execute(BaseRequest $request, BaseResponse $response): BaseResponse
    {
        if (!$request->getUserName()) {
            $request->setUserName($this->offsetGet("config")['userName']);
        }
        SignatureFactory::setSigner(new RSASigner(
            $this->offsetGet("config")['keystoreFilename'],
            $this->offsetGet("config")['keystorePassword'],
            $this->offsetGet("config")['keyContent'],
            $this->offsetGet("config")['certificateFilename'],
            $this->offsetGet("config")['certContent'],
            $this->offsetGet("config")['platformCertContent']
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
        $encodeKey = Str::random(24);
        $aes = new AES($encodeKey);
        $reqBodyEnc = $aes->encrypt($request->getRequestPlainText());
        //商户使用易联公钥加密key，得到c；
        $encodeKey = base64_encode($encodeKey);
        $reqKeyEnc = SignatureFactory::getSigner()->encrypt($encodeKey);
        //商户将报文组合b|c
        $params = $reqBodyEnc . "|" . $reqKeyEnc;
        $result = $this->request($params);
        $result = explode("|", $result);
        $response->handle($result);
        if ($logger instanceof LoggerInterface && $this->offsetGet("config")['debug']) {
            $logger->debug("响应原文：" . $response->getResponsePlainText());
        }
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
                'Content-type' => 'text/plain',
            ],
            'body' => $data,
            'verify' => false
        ];

        $response = $client->request('POST', '', $options);
        return $response->getBody()->getContents();
    }
}