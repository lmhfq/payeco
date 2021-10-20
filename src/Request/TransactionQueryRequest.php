<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 * Time: 下午3:37
 */

namespace Lmh\Payeco\Request;

/**
 * Class TransactionQueryRequest
 * 批量代收查询（200002）查询代收、认证交易结果。
 * @package Lmh\Payeco\Request
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 */
class TransactionQueryRequest extends BaseRequest
{
    protected $msgType = '200002';

    /**
     * @return string[]
     * @author lmh
     */
    protected function getTransDetails(): array
    {
        return [];
    }
}