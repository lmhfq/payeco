<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/25
 * Time: 下午2:08
 */

namespace Lmh\Payeco\Service\Transaction\Response;


use Illuminate\Support\Arr;
use Lmh\Payeco\Constant\ResponseCode;

class SendSmsCodeResponse extends BaseResponse
{
    /**
     * @var int
     */
    protected $remain;
    /**
     * @var int
     */
    protected $complated;
    /**
     * @var string
     */
    protected $expTime;
    /**
     * @var int
     */
    protected $needPwd;

    /**
     * @return int
     */
    public function getRemain(): int
    {
        return intval($this->remain);
    }

    /**
     * @return int
     */
    public function getComplated(): int
    {
        return intval($this->complated);
    }

    /**
     * @return string
     */
    public function getExpTime(): string
    {
        return $this->expTime;
    }

    /**
     * @return int
     */
    public function getNeedPwd(): int
    {
        return intval($this->needPwd);
    }


    public function handle(string $message)
    {
        parent::handle($message);
        if ($this->retCode == ResponseCode::SUCCESS) {
            $this->complated = Arr::get($this->body, 'Complated');
            $this->remain = Arr::get($this->body, 'Remain');
            $this->expTime = Arr::get($this->body, 'ExpTime');
            $this->needPwd = Arr::get($this->body, 'NeedPwd');
        }
    }
}