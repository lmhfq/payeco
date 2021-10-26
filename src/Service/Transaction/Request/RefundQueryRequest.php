<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/23
 * Time: 下午2:07
 */

namespace Lmh\Payeco\Service\Transaction\Request;

/**
 * Class RefundQueryRequest
 * 商户可以通过该接口查询退款申请的处理结果，建议申请成功后，第二天再发起查询交易。
  当退款成功后，返回的订单状态为“12：已退货”。
 * @package Lmh\Payeco\Service\Transaction\Request
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/26
 */
class RefundQueryRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $tradeCode = 'QueryRefund';
    /**
     * @var string 商户订单号
     */
    protected $merchOrderId;
    /**
     * @var string 商户退款申请号
     */
    protected $merchRefundId;
    /**
     * @var string 退款查询提交时间
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
     */
    public function getMerchRefundId(): string
    {
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
            'TradeTime' => $this->getTradeTime(),
        ];
    }
}