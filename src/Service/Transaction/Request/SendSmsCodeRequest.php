<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/25
 * Time: 上午11:20
 */

namespace Lmh\Payeco\Service\Transaction\Request;


class SendSmsCodeRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $tradeCode = 'ApiSendSmCodeV2';

    /**
     * @var string 短信凭证号
     */
    protected $smId;
    /**
     * @var string 商户订单号
     */
    protected $merchOrderId;
    /**
     * @var string
     */
    protected $tradeTime;
    /**
     * @var string
     */
    protected $mobileNo;
    /**
     * @var string
     */
    protected $verifyTradeCode = 'PayByAccV2';
    /**
     * @var string
     * 参数格式：行业编号|姓名|证件号码|银行卡号|交易金额|证件类型
     * 数据要求：姓名、证件号码、银行卡号(必填)
     * 行业编号：不填采用商户默认行业
     */
    protected $smParam;

    /**
     * @return string
     */
    public function getSmId(): string
    {
        return $this->smId;
    }

    /**
     * @param string $smId
     */
    public function setSmId(string $smId): void
    {
        $this->smId = $smId;
    }

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

    /**
     * @return string
     */
    public function getMobileNo(): string
    {
        return $this->mobileNo;
    }

    /**
     * @param string $mobileNo
     */
    public function setMobileNo(string $mobileNo): void
    {
        $this->mobileNo = $mobileNo;
    }

    /**
     * @return string
     */
    public function getVerifyTradeCode(): string
    {
        return $this->verifyTradeCode;
    }

    /**
     * @param string $verifyTradeCode
     */
    public function setVerifyTradeCode(string $verifyTradeCode): void
    {
        $this->verifyTradeCode = $verifyTradeCode;
    }

    /**
     * @return string
     */
    public function getSmParam(): string
    {
        return $this->smParam;
    }

    /**
     * @param string $smParam
     */
    public function setSmParam(string $smParam): void
    {
        $this->smParam = $smParam;
    }

    /**
     * @param false $encode
     * @return array
     * @author lmh
     */
    protected function getRequestData($encode = false): array
    {
        $data = [
            'Version' => $this->getVersion(),
            'MerchantId' => $this->getMerchantId(),
            'SmId' => $this->getSmId(),
            'MerchOrderId' => $this->getMerchOrderId(),
            'TradeTime' => $this->getTradeTime(),
            'MobileNo' => $this->getMobileNo(),
            'VerifyTradeCode' => $this->getVerifyTradeCode(),
            'SmParam' => $this->getSmParam()
        ];
        //采用UTF-8的base64格式编码
        if ($encode) {
            $data['SmParam'] = base64_encode($data['SmParam']);
        }
        return $data;
    }
}