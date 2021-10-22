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
class SendMessageRequestT extends TBaseRequest
{
    /**
     * @var string
     */
    protected $msgType = '500001';
    /**
     * @var string
     */
    protected $mobileNo;
    /**
     * @var string 用户收到的短信内容是：“短信验证码：xxxxxx，短信内容(TRANS_DESC)”
     */
    protected $transDesc;

    /**
     * @return string
     */
    public function getMobileNo(): string
    {
        return $this->mobileNo;
    }

    /**
     * @param string $mobileNo
     */
    public function setMobileNo(string $mobileNo): void
    {
        $this->mobileNo = $mobileNo;
    }

    /**
     * @return string
     */
    public function getTransDesc(): string
    {
        return $this->transDesc;
    }

    /**
     * @param string $transDesc
     */
    public function setTransDesc(string $transDesc): void
    {
        $this->transDesc = $transDesc;
    }

    /**
     * @return array[]
     * @author lmh
     */
    protected function getTransDetails(): array
    {
        return [
            [
                'ACC_NO' => $this->getAccNo(),
                'MOBILE_NO' => $this->getMobileNo(),
                'TRANS_DESC' => $this->getTransDesc()
            ]
        ];
    }
}