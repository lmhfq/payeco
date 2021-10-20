<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 * Time: 下午1:56
 */

namespace Lmh\Payeco\Request;

/**
 * Class AuthenticationCancelRequest
 * 解绑（300004）主动把系统已认证绑定的卡号进行解绑，解绑后卡号认证状态为“未绑定”状态。
 * 通过响应报文的pay_state判断解绑结果。
 * @package Lmh\Payeco\Request
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 */
class AuthenticationCancelRequest extends BaseRequest
{

    protected $msgType = '300004';

    protected function getTransDetails(): array
    {
        return [
            [
                'SN' => $this->getSn(),
                'ACC_NO' => $this->accNo,
            ]
        ];
    }
}