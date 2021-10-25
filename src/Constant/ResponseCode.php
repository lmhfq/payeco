<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 * Time: 上午11:13
 */

namespace Lmh\Payeco\Constant;


class ResponseCode
{
    /**
     * 接收成功类状态码，交易请求和交易查询请求返回的TRANS_STATE不代表订单状态，需要通过pay_state判断订单状态。。
     */
    public const SUCCESS = '0000';
    /**
     * 中间状态，交易状态不明确
     */
    public const C00A4 = '00A4';
    /**
     * 重复交易，Batch_No重复。 建议通过查询请求根据卡号、金额判断
     */
    public const C0094 = '0094';
    /**
     * 发短信环节返回G044错误码，请更换短信凭证码。
     */
    public const G044 = 'G044';
}