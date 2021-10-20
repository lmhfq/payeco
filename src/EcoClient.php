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
        $response = $client->request('POST', 'https://testagent.payeco.com:9444/service', $options);
        return $response->getBody()->getContents();
    }

    /* 发送数据返回接收数据 */
    public function postXmlUrl($url, $xmlStr, $ssl = false, $type = "Content-type: text/xml")
    {
        $ch = curl_init();
        $params = array();
        if ($type)
            $params[] = $type; //定义content-type为xml
        curl_setopt($ch, CURLOPT_URL, $url); //定义表单提交地址
        if ($ssl) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt($ch, CURLOPT_POST, 0);   //定义提交类型 1：POST ；0：GET
        //    curl_setopt($ch, CURLOPT_HEADER, 0); //定义是否显示状态头 1：显示 ； 0：不显示
        if ($params)
            curl_setopt($ch, CURLOPT_HTTPHEADER, $params); //定义请求类型
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //定义是否直接输出返回流
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlStr); //定义提交的数据，这里是XML文件
        //封禁"Expect"头域

        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        $xml_data = curl_exec($ch);
        //  var_dump($xml_data);exit;
        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        } else {
            curl_close($ch);
        }

        return $xml_data;
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