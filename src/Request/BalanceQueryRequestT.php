<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/18
 * Time: 下午2:02
 */

namespace Lmh\Payeco\Request;

/**
 * Class BalanceQueryRequest
 * 商户余额查询接口（600001）商户余额接口（600001）查询商户在易联代收付系统当前最新的余额。
 * @package Request
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 */
class BalanceQueryRequestT extends TBaseRequest
{

    protected $msgType = '600001';

    protected function getTransDetails(): array
    {
       return [
           [
               'SN'=>$this->getSn()
           ]
       ];
    }
}