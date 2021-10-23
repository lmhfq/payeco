<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/23
 * Time: 下午4:53
 */

namespace Lmh\Payeco\Service\Transaction\Response;


class NotifyResponse extends BaseResponse
{
    /**
     * @var string 商户订单号
     */
    protected $merchOrderId;
    /**
     * @var string 商户订单金额 单位为元
     */
    protected $amount;
    /**
     * @var string
     */
    protected $extData;
    /**
     * @var string 易联订单号
     */
    protected $orderId;
    /**
     * @var int
     */
    protected $status;
    /**
     * @var string
     */
    protected $payTime;
    /**
     * @var string string
     */
    protected $SettleDate;
    /**
     * @var string
     */
    protected $sign;

    /**
     * @return string
     */
    public function getMerchOrderId(): string
    {
        return $this->merchOrderId;
    }

    /**
     * @param string $merchOrderId
     */
    public function setMerchOrderId(string $merchOrderId): void
    {
        $this->merchOrderId = $merchOrderId;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getExtData(): string
    {
        return $this->extData;
    }

    /**
     * @param string $extData
     */
    public function setExtData(string $extData): void
    {
        $this->extData = $extData;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getPayTime(): string
    {
        return $this->payTime;
    }

    /**
     * @param string $payTime
     */
    public function setPayTime(string $payTime): void
    {
        $this->payTime = $payTime;
    }

    /**
     * @return string
     */
    public function getSettleDate(): string
    {
        return $this->SettleDate;
    }

    /**
     * @param string $SettleDate
     */
    public function setSettleDate(string $SettleDate): void
    {
        $this->SettleDate = $SettleDate;
    }

    /**
     * @return string
     */
    public function getSign(): string
    {
        return $this->sign;
    }

    /**
     * @param string $sign
     */
    public function setSign(string $sign): void
    {
        $this->sign = $sign;
    }

    protected function getResponseData(): array
    {
        return [
            'Version' => $this->getVersion(),
            'MerchantId' => $this->getMerchantId(),
            'MerchOrderId' => $this->getMerchOrderId(),
            'Amount' => $this->getAmount(),
            'ExtData' => $this->getExtData(),
            'OrderId' => $this->getOrderId(),
            'Status' => $this->getStatus(),
            'PayTime' => $this->getPayTime(),
            'SettleDate' => $this->getSettleDate(),
        ];
    }
}