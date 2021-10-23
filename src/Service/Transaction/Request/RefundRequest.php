<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/23
 * Time: 上午11:58
 */

namespace Lmh\Payeco\Service\Transaction\Request;


use Exception;

class RefundRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $tradeCode = 'RefundOrder';
    /**
     * @var string 商户订单号
     */
    protected $merchOrderId;
    /**
     * @var string 商户退款申请号
     */
    protected $merchRefundId;
    /**
     * @var string 商户退款金额 单位为元
     */
    protected $amount;
    /**
     * @var string 退款申请提交时间
     */
    protected $tradeTime;

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
     * @throws Exception
     * @author lmh
     */
    public function getMerchRefundId(): string
    {
        if (!$this->merchRefundId) {
            throw new Exception('merchRefundId必须');
        }
        return $this->merchRefundId;
    }

    /**
     * @param string $merchRefundId
     */
    public function setMerchRefundId(string $merchRefundId): void
    {
        $this->merchRefundId = $merchRefundId;
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
    public function getTradeTime(): string
    {
        return $this->tradeTime;
    }

    /**
     * @param string $tradeTime
     */
    public function setTradeTime(string $tradeTime): void
    {
        $this->tradeTime = $tradeTime;
    }


    protected function getRequestData($encode = false): array
    {
        return [
            'Version' => $this->getVersion(),
            'MerchantId' => $this->getMerchantId(),
            'MerchOrderId' => $this->getMerchOrderId(),
            'MerchRefundId' => $this->getMerchRefundId(),
            'Amount' => $this->getAmount(),
            'TradeTime' => $this->getTradeTime(),
        ];
    }
}