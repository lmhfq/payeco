<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/23
 * Time: 上午11:58
 */

namespace Lmh\Payeco\Service\Transaction\Response;


use Illuminate\Support\Arr;
use Lmh\Payeco\Constant\ResponseCode;

class RefundResponse extends BaseResponse
{
    /**
     * @var string 退款申请流水号
     */
    protected $tsNo;
    /**
     * @var string 商户退款金额
     */
    protected $amount;

    /**
     * @return string
     */
    public function getTsNo(): string
    {
        return $this->tsNo;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @param string $message
     * @author lmh
     */
    public function handle(string $message)
    {
        parent::handle($message);
        if ($this->retCode == ResponseCode::SUCCESS) {
            $this->tsNo = Arr::get($this->body, 'TsNo');
            $this->amount = Arr::get($this->body, 'Amount');
        }
    }
}