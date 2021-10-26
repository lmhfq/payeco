<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/23
 * Time: 下午2:07
 */

namespace Lmh\Payeco\Service\Transaction\Response;


use Illuminate\Support\Arr;
use Lmh\Payeco\Constant\ResponseCode;

class RefundQueryResponse extends BaseResponse
{
    /**
     * @var string 退款申请流水号
     */
    public $tsNo;
    /**
     * @var string 商户退款金额
     */
    public $amount;
    /**
     * @var string 商户退款申请号
     */
    public $merchRefundId;
    /**
     * @var string 退款成功时间
     */
    public $refundTime;
    /**
     * @var string 02申请中，08已撤销，12已退货
     */
    public $status;

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
            $this->merchRefundId = Arr::get($this->body, 'MerchRefundId');
            $this->status = Arr::get($this->body, 'Status');
            $this->refundTime = Arr::get($this->body, 'RefundTime');
        }
    }
}