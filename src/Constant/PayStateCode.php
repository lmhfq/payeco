<?php
declare(strict_types=1);


namespace Lmh\Payeco\Constant;


class PayStateCode
{
    /**
     * 订单交易成功。
     */
    public const SUCCESS = '0000';
    /**
     * 是中间状态，代表订单还在处理中，还没有最终结果
     */
    public const C00A4 = '00A4';
    /**
     * 订单已退款
     */
    public const T425 = 'T425';
    /**
     * 订单退款失败
     */
    public const T212 = 'T212';
    /**
     * 新用户（未绑定的）
     */
    public const T437 = 'T437';

    /**
     * 余额不足
     */
    public const C0051 = '0051';
    /**
     * 您卡上的余额不足
     */
    public const U011 = 'U011';
}