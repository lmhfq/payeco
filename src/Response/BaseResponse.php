<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/18
 * Time: 下午3:14
 */

namespace Lmh\Payeco\Response;


class BaseResponse
{

    public $transState;

    public $msgSign;

    public $transDetails=[];
}