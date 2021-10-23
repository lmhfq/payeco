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
    /**
     * @var string
     */
    protected $redirectUrl;

    public function handle(string $message)
    {
        parent::handle($message);
        if ($this->retCode == ResponseCode::SUCCESS) {
            $body = Arr::get($this->responseData, 'body', []);
            $this->orderId = Arr::get($body, 'OrderId');
            $resSign = Arr::get($body, 'Sign');
            $requestData = [
                'Version' => Arr::get($body, 'Version'),
                'MerchantId' => Arr::get($body, 'MerchantId'),
                'MerchOrderId' => Arr::get($body, 'MerchOrderId'),
                'Amount' => Arr::get($body, 'Amount'),
                'TradeTime' => Arr::get($body, 'TradeTime'),
                'OrderId' => $this->orderId,
                'VerifyTime' => Arr::get($body, 'VerifyTime'),
            ];
            //验证签名
            $requestData["Sign"] = $resSign;
            $this->redirectUrl = "/ppi/h5/plugin/itf.do?tradeId=h5Init&" . http_build_query($requestData);
        }
    }
}