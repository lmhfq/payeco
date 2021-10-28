<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 * Time: 下午3:56
 */

namespace Lmh\Payeco\Service\Transfer\Request;

/**
 * Class TransferQueryRequest
 * 批量代付查询（100002) 查询代付交易结果
 * @package Lmh\Payeco\Request
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 */
class TransferQueryRequest extends BaseRequest
{
    protected $msgType = '100002';
    /**
     * @var string
     */
    protected $version = '2.1';

    protected function getTransDetails(): array
    {
        return [
            [
                'BATCH_NO' => $this->getBatchNo()
            ]
        ];
    }
}