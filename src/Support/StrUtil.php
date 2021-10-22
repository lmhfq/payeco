<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/20
 * Time: 上午10:49
 */

namespace Lmh\Payeco\Support;


class StrUtil
{

    /**
     * 获取签名字段，Version=2.0,签名规则是如果某一字段值为空，则不计算该字段
     * BATCH_NO USER_NAME MSG_TYPE TRANS_STATE SN PAY_STATE ACC_NO ACC_NAME AMOUNT CNY USER_LEVEL（循环域）
     * @param array $data
     * @return string
     * @author lmh
     */
    public static function getSignText(array $data): string
    {
        $sign = !empty($data['BATCH_NO']) ? $data['BATCH_NO'] : '';
        $sign .= !empty($data['USER_NAME']) ? " " . $data['USER_NAME'] : '';
        $sign .= !empty($data['MSG_TYPE']) ? " " . $data['MSG_TYPE'] : '';
        $sign .= !empty($data['TRANS_STATE']) ? " " . $data['TRANS_STATE'] :'';
        if (isset($data['TRANS_DETAILS'])) {
            foreach ($data['TRANS_DETAILS'] as $item) {
                $sign .= !empty($item['SN']) ? " " . $item['SN'] : "";
                $sign .= !empty($item['PAY_STATE']) ? " " . $item['PAY_STATE'] : '';
                $sign .= !empty($item['ACC_NO']) ? " " . $item['ACC_NO'] :'';
                $sign .= !empty($item['ACC_NAME']) ? " " . $item['ACC_NAME'] : '';
                $sign .= !empty($item['AMOUNT']) ? " " . $item['AMOUNT'] : '';
                $sign .= !empty($item['CNY']) ? " " . $item['CNY'] : '';
            }
        }
        return trim($sign);
    }

}