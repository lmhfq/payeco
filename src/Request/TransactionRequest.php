<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/18
 * Time: 下午1:43
 */

namespace Lmh\Payeco\Request;

/**
 *  * Class TransactionRequest
 * 批量代收（200001、200005）客户通过易联付款给商户，一般用于充值等
 * 一.代收接口同时可以做认证，需要认证的，证件号、证件类型、手机号必填。
 * 二.代收新用户外呼认证流程：
 * Class TransactionRequest
 * @package Lmh\Payeco\Request
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 */
class TransactionRequest extends BaseRequest
{
    protected $msgType = '200001';
    /**
     * @var string 300001：填写一个1~5元之间的数值(例如：1.18)；不填写时随机取1~5元之间
     */
    protected $amount;
    /**
     * @var string 开户证件号
     */
    protected $idNo;
    /**
     * @var string 支付手机号，外呼认证拨打此号码
     */
    protected $mobileNo;
    /**
     * @var string
     */
    protected $merOrderNo;
    /**
     * @var string 外呼验密时，语音播报此交易描述，不宜太长。例如：[公司名称]快捷支付认证扣款，稍后将返还到原卡
     */
    protected $transDesc;
    /**
     * @var string
     */
    protected $smsCode;
    /**
     * @var string
     */
    protected $returnUrl;
    /**
     * @var string
     */
    protected $remark;

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount ?: '0.00';
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
    public function getIdNo(): string
    {
        return $this->idNo ?: '';
    }

    /**
     * @param string $idNo
     */
    public function setIdNo(string $idNo): void
    {
        $this->idNo = $idNo;
    }

    /**
     * @return string
     */
    public function getMobileNo(): string
    {
        return $this->mobileNo ?: '';
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
    public function getMerOrderNo(): string
    {
        return $this->merOrderNo ?: '';
    }

    /**
     * @param string $merOrderNo
     */
    public function setMerOrderNo(string $merOrderNo): void
    {
        $this->merOrderNo = $merOrderNo;
    }

    /**
     * @return string
     */
    public function getTransDesc(): string
    {
        return $this->transDesc ?: '';
    }

    /**
     * @param string $transDesc
     */
    public function setTransDesc(string $transDesc): void
    {
        $this->transDesc = $transDesc;
    }

    /**
     * @return string
     */
    public function getSmsCode(): string
    {
        return $this->smsCode ?: '';
    }

    /**
     * @param string $smsCode
     */
    public function setSmsCode(string $smsCode): void
    {
        $this->smsCode = $smsCode;
    }

    /**
     * @return string
     */
    public function getReturnUrl(): string
    {
        return $this->returnUrl ?: '';
    }

    /**
     * @param string $returnUrl
     */
    public function setReturnUrl(string $returnUrl): void
    {
        $this->returnUrl = $returnUrl;
    }

    /**
     * @return string
     */
    public function getRemark(): string
    {
        return $this->remark ?: '';
    }

    /**
     * @param string $remark
     */
    public function setRemark(string $remark): void
    {
        $this->remark = $remark;
    }

    protected function getTransDetails(): array
    {
        return [
            [
                'ACC_NO' => $this->getAccNo(),
                'ACC_NAME' => $this->getAccName(),
                'ID_NO' => $this->getIdNo(),
                'MOBILE_NO' => $this->getMobileNo(),
                'AMOUNT' => $this->getAmount(),
                'CNY' => 'CNY',
                'RETURN_URL' => $this->getReturnUrl(),
                'MER_ORDER_NO' => $this->getMerOrderNo(),
                'TRANS_DESC' => $this->getTransDesc(),
                'REMARK' => $this->getRemark(),
                'SMS_CODE' => $this->getSmsCode(),
            ]
        ];
    }
}