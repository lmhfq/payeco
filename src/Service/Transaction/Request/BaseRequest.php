<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/22
 * Time: 下午4:17
 */

namespace Lmh\Payeco\Service\Transaction\Request;


use Lmh\Payeco\Support\SignatureFactory;

abstract class BaseRequest
{
    /**
     * @var string
     */
    protected $version = '2.0.0';
    /**
     * @var string
     */
    protected $tradeCode;
    /**
     * @var string
     */
    protected $tradeUri = 'ppi/merchant/itf.do';
    /**
     * @var string
     */
    protected $merchantId;
    /**
     * @var array
     */
    protected $requestMessage;
    /**
     * @var string
     */
    protected $requestPlainText;

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
    public function getTradeCode(): string
    {
        return $this->tradeCode;
    }

    /**
     * @param string $tradeCode
     */
    public function setTradeCode(string $tradeCode): void
    {
        $this->tradeCode = $tradeCode;
    }

    /**
     * @return string
     */
    public function getTradeUri(): string
    {
        return $this->tradeUri;
    }

    /**
     * @param string $tradeUri
     */
    public function setTradeUri(string $tradeUri): void
    {
        $this->tradeUri = $tradeUri;
    }




    /**
     * @return string
     */
    public function getMerchantId(): string
    {
        return $this->merchantId ?: '';
    }

    /**
     * @param string $merchantId
     */
    public function setMerchantId(string $merchantId): void
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @return array
     */
    public function getRequestMessage(): array
    {
        return $this->requestMessage;
    }

    /**
     * @return string
     */
    public function getRequestPlainText(): string
    {
        return $this->requestPlainText;
    }


    protected abstract function getRequestData($encode = false): array;

    /**
     * @return void
     * @throws Exception
     * @author lmh
     */
    public function handle(): void
    {
//        $vars = get_object_vars($this);
//
//        $requestData = [];
//        foreach ($vars as $key => $value) {
//            $requestData[Str::studly($key)] = $value;
//        }
        $signData = $this->getRequestData();

        $params = http_build_query($signData);
        $sign = SignatureFactory::getSigner()->sign($params);

        $requestData = $this->getRequestData(true);

        $requestData["Sign"] = $sign;
        $this->requestMessage = array_merge(['TradeCode' => $this->getTradeCode()], $requestData);
        $this->requestPlainText = http_build_query($this->requestMessage);
    }

}