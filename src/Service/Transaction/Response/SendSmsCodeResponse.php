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
    public $remain;
    /**
     * @var int
     */
    public $complated;
    /**
     * @var int
     */
    public $expTime;
    /**
     * @var string
     */
    public $needPwd;

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