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
     * @var string
     */
    protected $batchNo;
    /**
     * @var string
     */
    protected $msgSign;
    /**
     * @var array
     */
    protected $transDetails;

    protected $requestPlainText;

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
     * @return mixed
     */
    public function getRequestPlainText()
    {
        return $this->requestPlainText;
    }


    protected abstract function getTransDetails(): array;

    /**
     * @return void
     * @throws Exception
     * @author lmh
     */
    public function handle(): void
    {
        $data = [
            'VERSION' => $this->getVersion(),
            'USER_NAME' => $this->getUserName(),
            'BATCH_NO' => $this->getBatchNo(),
            'MSG_TYPE' => $this->getMsgType(),
            'TRANS_STATE' => '',
            'TRANS_DETAILS' => $this->getTransDetails()
        ];
        $data['MSG_SIGN'] = SignatureFactory::getSigner()->sign($this->getSignText($data));
        $this->requestPlainText = Xml::build($data);
    }

    /**
     * @param array $data
     * @return string
     * @author lmh
     */
    public function getSignText(array $data): string
    {
        $sign = $data['BATCH_NO'];
        $sign .= isset($data['USER_NAME']) ? " " . $data['USER_NAME'] : "";
        $sign .= isset($data['MSG_TYPE']) ? " " . $data['MSG_TYPE'] : "";
        $sign .= isset($data['TRANS_STATE']) ? " " . $data['TRANS_STATE'] : "";
        foreach ($data['TRANS_DETAILS'] as $item) {
            $sign .= isset($item['SN']) ? " " . $item['SN'] : "";
            $sign .= isset($item['PAY_STATE']) ? " " . $item['PAY_STATE'] : "";
            $sign .= isset($item['ACC_NO']) ? " " . $item['ACC_NO'] : "";
            $sign .= isset($item['ACC_NAME']) ? " " . $item['ACC_NAME'] : "";
            $sign .= isset($item['AMOUNT']) ? " " . $item['AMOUNT'] : "";
            $sign .= isset($item['CNY']) ? " " . $item['CNY'] : "";
        }
        return trim($sign);
    }
}