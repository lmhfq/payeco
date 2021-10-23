<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/22
 * Time: 下午6:10
 */

namespace Lmh\Payeco\Service\Transaction\Response;


use Illuminate\Support\Arr;
use Lmh\Payeco\Support\Xml;

class BaseResponse
{
    /**
     * 先取head中的retCode码，如retCode码不为’0000’,则此交易失败，无需取body部分；报文格式如下：
     * @var string
     */
    protected $retCode;
    /**
     * @var string
     */
    protected $retMsg;
    /**
     * @var string
     */
    protected $responsePlainText;
    /**
     * @var array
     */
    protected $responseData;

    /**
     * @return string
     */
    public function getResponsePlainText(): string
    {
        return $this->responsePlainText;
    }


    public function handle(string $message)
    {
        $this->responsePlainText = $message;
        $this->responseData = Xml::parse(str_replace('encoding="GBK"', 'encoding="UTF-8"', $this->responsePlainText));
        $head = $this->responseData['head'] ?? [];
        $this->retCode = Arr::get($head, 'retCode');
        $this->retMsg = Arr::get($head, 'retMsg');
    }
}