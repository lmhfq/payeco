<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/18
 * Time: 下午3:12
 */

namespace Lmh\Payeco\Request;


use Exception;
use Lmh\PayEco\Support\SignatureFactory;
use Lmh\Payeco\Support\StrUtil;
use Lmh\Payeco\Support\Xml;

abstract class BaseRequest
{
    /**
     * @var string
     */
    protected $version = '2.0';
    /**
     * @var string
     */
    protected $userName;
    /**
     * @var string
     */
    protected $msgType;
    /**
     * @var string 批次号
     */
    protected $batchNo;
    /**
     * @var string
     */
    protected $requestPlainText;

    public $detailFields = ["SN", "BANK_CODE", "ACC_NO", "ACC_NAME", "ACC_PROVINCE", "ACC_CITY", "AMOUNT", "MOBILE_NO", "PAY_STATE", "BANK_NO", "BANK_NAME", "ACC_TYPE", "ACC_PROP", "ID_TYPE", "ID_NO", "CNY", "EXCHANGE_RATE", "SETT_AMOUNT", "USER_LEVEL", "SETT_DATE", "REMARK", "RESERVE", "RETURN_URL", "MER_ORDER_NO", "MER_SEQ_NO", "QUERY_NO_FLAG", "TRANS_DESC", "SMS_CODE"];

    /**
     * $detailFields
     * @var string 流水号 总长6—10位, 有字母要用大写
     */
    protected $sn;
    /**
     * @var string 卡号
     */
    protected $accNo;
    /**
     * @var string 开户名
     */
    protected $accName;

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName ?: '';
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getMsgType(): string
    {
        return $this->msgType;
    }

    /**
     * @return string
     */
    public function getBatchNo(): string
    {
        return $this->batchNo ?: '';
    }

    /**
     * @param string $batchNo
     */
    public function setBatchNo(string $batchNo)
    {
        $this->batchNo = $batchNo;
    }

    /**
     * @return string
     */
    public function getRequestPlainText(): string
    {
        return $this->requestPlainText ?: '';
    }

    /**
     * @return string
     */
    public function getSn(): string
    {
        return $this->sn ?: '';
    }

    /**
     * @param string $sn
     */
    public function setSn(string $sn): void
    {
        $this->sn = $sn;
    }

    /**
     * @return string
     */
    public function getAccNo(): string
    {
        return $this->accNo ?: '';
    }

    /**
     * @param string $accNo
     */
    public function setAccNo(string $accNo): void
    {
        $this->accNo = $accNo;
    }

    /**
     * @return string
     */
    public function getAccName(): string
    {
        return $this->accName ?: '';
    }

    /**
     * @param string $accName
     */
    public function setAccName(string $accName): void
    {
        $this->accName = $accName;
    }

    /**
     * 获取请求参数
     * @return array
     * @author lmh
     */
    protected abstract function getTransDetails(): array;

    /**
     * @return void
     * @throws Exception
     * @author lmh
     */
    public function handle(): void
    {
        $requestData = [
            'VERSION' => $this->getVersion(),
            'MSG_TYPE' => $this->getMsgType(),
            'BATCH_NO' => $this->getBatchNo(),
            'USER_NAME' => $this->getUserName(),
            'TRANS_STATE' => '',
        ];
        $transDetails = $this->getTransDetails();
        $transDetailsParams = [];
        if (empty($transDetails) || !isset($transDetails[0])) {
            $transDetails = [$transDetails];
        }
        foreach ($transDetails as $detail) {
            $params = [];
            foreach ($this->detailFields as $field) {
                $params[$field] = $detail[$field] ?? '';
            }
            $transDetailsParams[] = $params;
        }
        $requestData['TRANS_DETAILS'] = $transDetailsParams;
        $requestData['MSG_SIGN'] = SignatureFactory::getSigner()->sign(StrUtil::getSignText($requestData));
        $this->requestPlainText = Xml::build($requestData);
    }


}