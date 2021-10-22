<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/22
 * Time: 下午5:57
 */

namespace Lmh\Payeco\Service\Transaction\Request;


class TradeRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $tradeCode = 'PayOrder';
    /**
     * @var string 商户订单号
     */
    protected $merchOrderId;
    /**
     * @var string 单位为元
     */
    protected $amount;
    /**
     * @var string
     */
    protected $orderDesc;
    /**
     * @var string
     */
    protected $tradeTime;
    /**
     * @var string
     */
    protected $expTime;
    /**
     * @var string
     */
    protected $notifyUrl;
    /**
     * @var string
     */
    protected $returnUrl;
    /**
     * @var string
     */
    protected $extData;
    /**
     * @var string
     */
    protected $miscData;
    /**
     * @var int
     */
    protected $notifyFlag = 1;
    /**
     * @var string
     */
    protected $clientIp;

    protected function getSignData(): string
    {
        // TODO: Implement getSignData() method.
    }
}