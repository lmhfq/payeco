<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/18
 * Time: 下午1:52
 */

namespace Lmh\Payeco\Request;

/**
 * Class SendMessageRequest
 * 短信验证码（500001）发送短信验证码和重新发送短信验证码；
 * @package Request
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/18
 */
class SendMessageRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $msgType = '500001';

    protected function getTransDetails(): array
    {
        return [
            [
                'SN'=>'',
                'ACC_NO'=>'6227003811930123783',
                'ACC_NAME'=>'',
                'ID_NO'=>'',
                'MOBILE_NO'=>'2022132743',
                'AMOUNT'=>'',
                'CNY'=>'',
                'PAY_STATE'=>'',
                'MER_ORDER_NO'=>'',
                'TRANS_DESC'=>'短信内容'
            ]
        ];
    }
}