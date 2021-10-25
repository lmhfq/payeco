<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/23
 * Time: 上午10:58
 */

namespace Lmh\Payeco\Service\Transaction\Response;


use Illuminate\Support\Arr;
use Lmh\Payeco\Constant\ResponseCode;

class TradeResponse extends BaseResponse
{
    /**
     * @var string 插件平台返回的订单系统订单号
     */
    protected $orderId;

    public function handle(string $message)
    {
        parent::handle($message);
        if ($this->retCode == ResponseCode::SUCCESS) {
            $this->orderId = Arr::get($this->body, 'OrderId');
        }
    }
}