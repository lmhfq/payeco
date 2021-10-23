<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/22
 * Time: 下午4:16
 */

namespace Lmh\Payeco\Service\Transaction;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Lmh\Payeco\Service\Transaction\Request\BaseRequest;
use Lmh\Payeco\Service\Transaction\Response\BaseResponse;
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
     * @author lmh
     */
    public function execute(BaseRequest $request, BaseResponse $response): BaseResponse
    {
        if (!$request->getMerchantId()) {
            $request->setMerchantId($this->offsetGet("config")['merchantId']);
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
        $params = [
            'data' => $request->getRequestMessage(),
            'uri' => $request->getTradeUri()
        ];
        $result = $this->request($params);
        $response->handle($result);
        if ($logger instanceof LoggerInterface && $this->offsetGet("config")['debug']) {
            $logger->debug("响应原文：" . $response->getResponsePlainText());
        }
        return $response;
    }


    /**
     * @param array $params
     * @return string
     * @throws GuzzleException
     * @author lmh
     */
    private function request(array $params)
    {
        $client = new Client($this->offsetGet("config")['http']);
        $options = [
            'headers' => [
                'Content-type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => $params['data'],
            'verify' => false
        ];
        $response = $client->request('POST', $params['uri'], $options);
        return $response->getBody()->getContents();
    }
}