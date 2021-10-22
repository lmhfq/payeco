<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 * Time: 下午1:40
 */

namespace Lmh\Payeco\Request;

/**
 * Class AuthenticationRequest
 * 认证（300001、300003）外呼验密，如果验密成功，则系统会绑定银行卡号、身份证号和姓名，下次可以直接扣款。
 * 认证要素：卡号+姓名+身份证。3个要素要一致才会发起外呼，否则当失败处理，具体失败原因在REMARK字段说明。
 * @package Lmh\Payeco\Request
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 */
class AuthenticationRequestT extends TBaseRequest
{
    protected $msgType = '300001';
    /**
     * @var string 300001：填写一个1~5元之间的数值(例如：1.18)；不填写时随机取1~5元之间
     */
    protected $amount;
    /**
     * @var string 开户证件号
     */
    protected $idNo;
    /**
     * @var string
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
        return $this->transDesc;
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

    protected function getTransDetails(): array
    {
        return [
            [
                'SN' => $this->getSn(),
                'BANK_CODE' => '',
                'ACC_NO' => $this->getAccNo(),
                'ACC_NAME' => $this->getAccName(),
//                'AMOUNT' => $this->getAmount(),
                'ID_NO' => $this->getIdNo(),
                'MOBILE_NO' => $this->getMobileNo(),
                'CNY' => 'CNY',
                'RETURN_URL' => $this->getReturnUrl(),
                'PAY_STATE' => '',
                'MER_ORDER_NO' => $this->getMerOrderNo(),
                'TRANS_DESC' => $this->getTransDesc(),
                'SMS_CODE' => $this->getSmsCode(),
            ]
        ];
    }
}