<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/22
 * Time: 下午5:57
 */

namespace Lmh\Payeco\Service\Transaction\Request;


class TradeRequest extends BaseRequest
{
    /**
     * @var string
     */
    protected $tradeCode = 'PayByAccV2';
    /**
     * @var string 商户订单号
     */
    protected $merchOrderId;
    /**
     * @var string 商户行业编号 未上送此字段时，系统将使用商户配置中对应的行业
     */
    protected $industryId;
    /**
     * @var string 商户订单金额 单位为元
     */
    protected $amount;
    /**
     * @var string
     */
    protected $orderDesc;
    /**
     * @var string
     */
    protected $tradeTime;
    /**
     * @var string
     */
    protected $expTime;
    /**
     * @var string
     */
    protected $notifyUrl;
    /**
     * @var string
     */
    protected $extData;
    /**
     * @var string 手机号|VIP标识|用户ID|姓名|证件号码|银行卡号|开户省市|手机号码验证标识|认证快付协议标识|SIM卡卡号|设备机身号|MAC地址|LBS信息|证件类型|
     */
    protected $miscData;
    /**
     * @var int
     */
    protected $notifyFlag = 1;
    /**
     * @var string
     */
    protected $smId;
    /**
     * @var string
     */
    protected $smCode;
    /**
     * @var string
     */
    protected $pwd;

    /**
     * @return string
     */
    public function getMerchOrderId(): string
    {
        return $this->merchOrderId ?: '';
    }

    /**
     * @param string $merchOrderId
     */
    public function setMerchOrderId(string $merchOrderId): void
    {
        $this->merchOrderId = $merchOrderId;
    }

    /**
     * @return string
     */
    public function getIndustryId(): string
    {
        return $this->industryId ?: '';
    }

    /**
     * @param string $industryId
     */
    public function setIndustryId(string $industryId): void
    {
        $this->industryId = $industryId;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getOrderDesc(): string
    {
        return $this->orderDesc ?: '';
    }

    /**
     * @param string $orderDesc
     */
    public function setOrderDesc(string $orderDesc): void
    {
        $this->orderDesc = $orderDesc;
    }

    /**
     * @return string
     */
    public function getTradeTime(): string
    {
        return $this->tradeTime ?: '';
    }

    /**
     * @param string $tradeTime
     */
    public function setTradeTime(string $tradeTime): void
    {
        $this->tradeTime = $tradeTime;
    }

    /**
     * @return string
     */
    public function getExpTime(): string
    {
        return $this->expTime ?: '';
    }

    /**
     * @param string $expTime
     */
    public function setExpTime(string $expTime): void
    {
        $this->expTime = $expTime;
    }

    /**
     * @return string
     */
    public function getNotifyUrl(): string
    {
        return $this->notifyUrl ?: '';
    }

    /**
     * @param string $notifyUrl
     */
    public function setNotifyUrl(string $notifyUrl): void
    {
        $this->notifyUrl = $notifyUrl;
    }

    /**
     * @return string
     */
    public function getExtData(): string
    {
        return $this->extData ?: '';
    }

    /**
     * @param string $extData
     */
    public function setExtData(string $extData): void
    {
        $this->extData = $extData;
    }

    /**
     * @return string
     */
    public function getMiscData(): string
    {
        return $this->miscData ?: '';
    }

    /**
     * @param string $miscData
     */
    public function setMiscData(string $miscData): void
    {
        $this->miscData = $miscData;
    }

    /**
     * @return int
     */
    public function getNotifyFlag(): int
    {
        return $this->notifyFlag;
    }

    /**
     * @param int $notifyFlag
     */
    public function setNotifyFlag(int $notifyFlag): void
    {
        $this->notifyFlag = $notifyFlag;
    }

    /**
     * @return string
     */
    public function getSmId(): string
    {
        return $this->smId;
    }

    /**
     * @param string $smId
     */
    public function setSmId(string $smId): void
    {
        $this->smId = $smId;
    }

    /**
     * @return string
     */
    public function getSmCode(): string
    {
        return $this->smCode;
    }

    /**
     * @param string $smCode
     */
    public function setSmCode(string $smCode): void
    {
        $this->smCode = $smCode;
    }

    /**
     * @return string
     */
    public function getPwd(): string
    {
        return $this->pwd ?: '';
    }

    /**
     * @param string $pwd
     */
    public function setPwd(string $pwd): void
    {
        $this->pwd = $pwd;
    }


    protected function getRequestData($encode = false): array
    {
        $data = [
            'Version' => $this->getVersion(),
            'MerchantId' => $this->getMerchantId(),
            'IndustryId' => $this->getIndustryId(),
            'MerchOrderId' => $this->getMerchOrderId(),
            'Amount' => $this->getAmount(),
            'OrderDesc' => $this->getOrderDesc(),
            'TradeTime' => $this->getTradeTime(),
            'ExpTime' => $this->getExpTime(),
            'NotifyUrl' => $this->getNotifyUrl(),
            'ExtData' => $this->getExtData(),
            'MiscData' => $this->getMiscData(),
            'NotifyFlag' => $this->getNotifyFlag(),
            'SmId' => $this->getSmId(),
            'SmCode' => $this->getSmCode(),
            'pwd' => $this->getPwd(),
        ];
        //采用UTF-8的base64格式编码
        if ($encode) {
            $data['OrderDesc'] = base64_encode($data['OrderDesc']);
            $data['ExtData'] = $data['ExtData'] ? base64_encode($data['ExtData']) : '';
            $data['MiscData'] = base64_encode($data['MiscData']);
            $data['NotifyUrl'] = urlencode($data['NotifyUrl']);
        }
        return $data;
    }
}