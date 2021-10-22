<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 * Time: 下午3:48
 */

namespace Lmh\Payeco\Request;

/**
 * Class TransferRequest
 * 批量代付（100001）商户通过易联付款给客户，一般用于提现等。
 * @package Lmh\Payeco\Request
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 */
class TransferRequestT extends TBaseRequest
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

    protected function getTransDetails(): array
    {
        return [
            [
                'ACC_NO' => $this->getAccNo(),
                'ACC_NAME' => $this->getAccName(),
                'AMOUNT' => $this->getAmount(),
                'CNY' => 'CNY',
                'MER_ORDER_NO' => $this->getMerOrderNo(),
            ]
        ];
    }
}