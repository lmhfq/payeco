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
            $this->orderId = Arr::get( $this->body, 'OrderId');
            $resSign = Arr::get( $this->body, 'Sign');
            $requestData = [
                'Version' => Arr::get($this->body, 'Version'),
                'MerchantId' => Arr::get($this->body, 'MerchantId'),
                'MerchOrderId' => Arr::get($this->body, 'MerchOrderId'),
                'Amount' => Arr::get($this->body, 'Amount'),
                'TradeTime' => Arr::get($this->body, 'TradeTime'),
                'OrderId' => $this->orderId,
                'VerifyTime' => Arr::get($this->body, 'VerifyTime'),
            ];
            //验证签名
            $requestData["Sign"] = $resSign;
            $redirectParams = http_build_query($requestData);
            $redirectParams = urldecode($redirectParams);
            $this->redirectUrl = "/ppi/h5/plugin/itf.do?tradeId=h5Init&" .$redirectParams;
        }
    }
}