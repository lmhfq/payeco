<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 * Time: 下午1:37
 */

namespace Lmh\Payeco\Request;
/**
 * Class AuthenticationQueryRequest
 * 认证查询（绑定查询）（300002）查询银行卡号绑定状态
 * @package Lmh\Payeco\Request
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 */
class AuthenticationQueryRequestT extends TBaseRequest
{
    protected $msgType = '300002';

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