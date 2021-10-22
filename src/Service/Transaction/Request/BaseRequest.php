<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/22
 * Time: 下午4:17
 */

namespace Lmh\Payeco\Service\Transaction\Request;


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
    protected $merchantId;

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


    protected abstract function getSignData(): string;

    /**
     * @return void
     * @throws Exception
     * @author lmh
     */
    public function handle(): void
    {
        $requestData = get_object_vars($this);
        $requestData= array_filter($requestData, function ($v) {
            return $v !== null;
        });



    }

}