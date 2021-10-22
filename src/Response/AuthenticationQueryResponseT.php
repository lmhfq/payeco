<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 * Time: 下午2:10
 */

namespace Lmh\Payeco\Response;

class AuthenticationQueryResponseT extends TBaseResponse
{
    protected $mobileNo;

    public function handle(array $result)
    {
        parent::handle($result);
        $this->mobileNo = $this->transDetails[0]['MOBILE_NO'] ?? '';
    }
}