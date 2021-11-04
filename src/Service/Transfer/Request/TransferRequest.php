<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 * Time: 下午3:48
 */

namespace Lmh\Payeco\Service\Transfer\Request;

/**
 * Class TransferRequest
 * 批量代付（100001）商户通过易联付款给客户，一般用于提现等。
 * @package Lmh\Payeco\Request
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 */
class TransferRequest extends BaseRequest
{
    protected $msgType = '100001';
    /**
     * @var string
     */
    protected $version = '2.1';
    /**
     * @var string 金额
     */
    protected $amount;
    /**
     * @var string
     */
    protected $merOrderNo;
    /**
     * @var string
     */
    protected $provice;
    /**
     * @var string
     */
    protected $city;
    /**
     * @var string 目前只支持身份证。
     * 0：身份证，1: 户口簿，2：护照，3：军官证，4：士兵证，5：港澳居民来往内地通行证，6： 台湾同胞来往内地通行证，7： 临时身份证，8：外国人居留证，9：警官证，10：其他证件
     */
    protected $cardType = '0';
    /**
     * @var string
     */
    protected $cardNo;
    /**
     * @var string    0私人，1公司。默认0
     */
    protected $bankAccountType = 0;

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
    public function getProvice(): string
    {
        return $this->provice;
    }

    /**
     * @param string $provice
     */
    public function setProvice(string $provice): void
    {
        $this->provice = $provice;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCardType(): string
    {
        return $this->cardType;
    }

    /**
     * @param string $cardType
     */
    public function setCardType(string $cardType): void
    {
        $this->cardType = $cardType;
    }

    /**
     * @return string
     */
    public function getCardNo(): string
    {
        return $this->cardNo ?: '';
    }

    /**
     * @param string $cardNo
     */
    public function setCardNo(string $cardNo): void
    {
        $this->cardNo = $cardNo;
    }

    /**
     * @return string
     */
    public function getBankAccountType()
    {
        return $this->bankAccountType;
    }

    /**
     * @param string $bankAccountType
     */
    public function setBankAccountType($bankAccountType): void
    {
        $this->bankAccountType = $bankAccountType;
    }


    protected function getTransDetails(): array
    {
        return [
            [
                'SN' => $this->getSn(),
                'ACC_NO' => $this->getAccNo(),
                'ACC_NAME' => $this->getAccName(),
                'AMOUNT' => $this->getAmount(),
                'CNY' => 'CNY',
                'ACC_PROP' => $this->getBankAccountType(),
                'ID_TYPE' => $this->getCardType(),
                'ID_NO' => $this->getCardNo(),
                'MER_ORDER_NO' => $this->getMerOrderNo(),
            ]
        ];
    }
}