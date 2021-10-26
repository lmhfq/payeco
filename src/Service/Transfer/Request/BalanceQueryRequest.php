<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/25
 * Time: 下午6:59
 */

namespace Lmh\Payeco\Service\Transfer\Request;
/**
 * Class BalanceQueryRequest
 * 商户余额查询接口（600001）商户余额接口（600001）查询商户在易联代收付系统当前最新的余额。
 * @package Request
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/25
 */
class BalanceQueryRequest extends BaseRequest
{

    protected $msgType = '600001';
    /**
     * @var string
     */
    protected $version = '2.1';

    protected function getTransDetails(): array
    {
        return [
            [
                'SN' => $this->getSn()
            ]
        ];
    }
}