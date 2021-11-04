<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/23
 * Time: 上午11:36
 */

namespace Lmh\Payeco\Entity;

use Exception;
use Lmh\Payeco\Constant\IndustryId;

/**
 * Class MiscData
 * @package Lmh\Payeco\Entity
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/23
 */
class TradeData
{
    /**
     * @var string
     */
    public $mobile = '';
    /**
     * @var string
     */
    public $accountName = '';
    /**
     * @var string
     */
    public $cardNo = '';
    /**
     * @var string 需要商户保证唯一性；重新发送短信传递相同的【短信凭证号】，发短信环节返回G044错误码，请更换短信凭证码。
     */
    public $smId;
    /**
     * @var string
     */
    public $bankCardNo = '';
    /**
     * @var string 01：身份证 02：护照 03：军人证 04：台胞证05：回乡证06：港澳通行证
     */
    public $accountType = '01';
    /**
     * @var string
     */
    public $amount = '';
    /**
     * 开户省 格式为【省份,城市】，如：广东省,广州市
     * @return string
     * @author lmh
     */
    public $province;
    /**
     * @var string 开户城市
     */
    public $city;
    /**
     * @var string
     */
    public $industryId = 11;


    /**
     * 获取订单订单扩展信息
     *通用- 手机号|VIP标识|用户ID|姓名|证件号码|银行卡号|开户省市|手机号码验证标识|认证快付协议标识|SIM卡卡号|设备机身号|MAC地址|LBS信息|证件类型|
     *电商- 手机号|VIP标识|用户ID|姓名|证件号码|银行卡号|开户省市|送货地址|手机号码验证标识|认证快付协议标识|SIM卡卡号|设备机身号|MAC地址|LBS信息|证件类型|
     * 手机号、姓名、证件号码、银行卡号(必填)
     * @return string
     * @throws Exception
     * @author lmh
     */
    public function getMiscData(): string
    {
        $provinceCity = '';
        if ($this->province) {
            $provinceCity = $this->province . '.' . $this->city;
        }
        $default = [
            $this->mobile,
            '',
            '',
            $this->accountName,
            $this->cardNo,
            $this->bankCardNo,
            $provinceCity,
        ];
        switch ($this->industryId) {
            case IndustryId::DEFAULT:
                //手机号码验证标识|认证快付协议标识|SIM卡卡号|设备机身号|MAC地址|LBS信息|
                $data = array_merge($default, [
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $this->accountType
                ]);
                break;
            case IndustryId::E_COMMERCE:
                //送货地址|手机号码验证标识|认证快付协议标识|SIM卡卡号|设备机身号|MAC地址|LBS信息|证件类型|
                $data = array_merge($default, [
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $this->accountType
                ]);
                break;
            default:
                throw new Exception('不支持的行业');
        }
        return implode('|', $data);
    }

    /**
     * 获取短信参数
     * 行业编号|姓名|证件号码|银行卡号|交易金额|证件类型
     * 数据要求：姓名、证件号码、银行卡号(必填)
     * @return string
     * @author lmh
     */
    public function getSmsParams(): string
    {
        $data = [
            $this->industryId,
            $this->accountName,
            $this->cardNo,
            $this->bankCardNo,
            $this->amount,
            $this->accountType,
        ];
        return implode('|', $data);
    }
}