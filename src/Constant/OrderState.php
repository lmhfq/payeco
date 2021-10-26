<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/23
 * Time: 下午2:02
 */

namespace Lmh\Payeco\Constant;


class OrderState
{
    /**
     * 未支付
     */
    public const NO_PAY = '01';
    /**
     * 已支付
     */
    public const SUCCESS = '02';
    /**
     * 已退款(全额撤销/冲正)
     */
    public const REFUNDED = '03';
    /**
     * 支付中
     */
    public const PAYING = '06';
    /**
     * 退款中
     */
    public const REFUNDING = '07';
    /**
     * 已被商户撤销
     */
    public const REFUND_CANCEL = '08';
    /**
     * 退款成功、已退货
     */
    public const REFUND_SUCCESS = '12';
}