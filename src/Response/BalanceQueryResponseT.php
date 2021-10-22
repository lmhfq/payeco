<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 * Time: 下午2:03
 */

namespace Lmh\Payeco\Response;


class BalanceQueryResponseT extends TBaseResponse
{
    /**
     * @var string
     */
    protected $amount;

    public function handle(array $result)
    {
        parent::handle($result);
        $this->amount = $this->transDetails[0]['AMOUNT'] ?? '';
    }
}