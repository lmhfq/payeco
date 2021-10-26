<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/18
 * Time: 下午3:14
 */

namespace Lmh\Payeco\Service\Transfer\Response;


use Exception;
use Lmh\Payeco\Support\AES;
use Lmh\Payeco\Support\SignatureFactory;
use Lmh\Payeco\Support\StrUtil;
use Lmh\Payeco\Support\Xml;

class BaseResponse
{
    /**
     * @var string
     * 接收成功类状态码，交易请求和交易查询请求返回的TRANS_STATE不代表订单状态，需要通过pay_state判断订单状态。
     * 0000表示请求成功
     */
    protected $transState;
    /**
     * @var string
     * PAY_STATE处理建议：
     * 1.0000：代表订单交易成功；
     * 2.00A4：是中间状态，代表订单还在处理中，还没有最终结果。
     * 3.除上述两个返回码外，其他返回码当失败处理。
     */
    protected $payState;
    /**
     * @var string
     */
    protected $userName;
    /**
     * @var string
     */
    protected $batchNo;
    /**
     * @var string
     */
    protected $remark;
    /**
     * @var array
     */
    protected $transDetails = [];
    /**
     * @var string
     */
    protected $responsePlainText;
    /**
     * @var array
     */
    protected $responseData = [];

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName ?: '';
    }

    /**
     * @return string
     */
    public function getBatchNo(): string
    {
        return $this->batchNo ?: '';
    }

    /**
     * @return string
     */
    public function getRemark(): string
    {
        return $this->remark ?: '';
    }

    /**
     * @return string
     */
    public function getResponsePlainText(): string
    {
        return $this->responsePlainText ?: '';
    }

    /**
     * @return array
     */
    public function getResponseData(): array
    {
        return $this->responseData;
    }

    /**
     * @param array $result
     * @throws Exception
     * @author lmh
     */
    public function handle(array $result)
    {
        if (!isset($result[1])) {
            throw new Exception($result[0] ?? '响应参数错误');
        }
        //商户使用商户私钥，解密c，得到3des密钥明文key；
        $signer = SignatureFactory::getSigner();
        $decodeKey = $signer->decrypt($result[1]);
        //商户使用key对b进行解密，得到a
        $aes = new AES(base64_decode($decodeKey));
        $response = $aes->decrypt($result[0]);
        $this->responsePlainText = $response;
        $this->responseData = Xml::parse(str_replace('encoding="GBK"', 'encoding="UTF-8"', $this->responsePlainText));
        $msgSign = $this->responseData['MSG_SIGN'] ?? '';
        //商户使用易联公钥对a进行验签。
        $plainText = StrUtil::getSignText($this->responseData);

        $verify = $signer->verify($plainText, $msgSign);
        if (!$verify) {
            throw new Exception('签名验证失败');
        }
        $this->transState = $this->responseData['TRANS_STATE'] ?? '';
        if (isset($this->responseData['TRANS_DETAILS'])) {
            $this->transDetails = isset($this->responseData['TRANS_DETAILS']['TRANS_DETAIL'][0]) ? $this->responseData['TRANS_DETAILS']['TRANS_DETAIL'] : [$this->responseData['TRANS_DETAILS']['TRANS_DETAIL']];
        }
        $this->payState = $this->transDetails[0]['PAY_STATE'] ?? '';
        $this->userName = $this->responseData['USER_NAME'] ?? '';
        $this->batchNo = $this->responseData['BATCH_NO'] ?? '';
        $this->remark = $this->transDetails[0]['REMARK'] ?? '';
    }
}