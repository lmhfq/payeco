<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/22
 * Time: 下午2:36
 */

namespace Lmh\Payeco;


class Factory
{
    /**
     * @param array $config
     * @return EcoTClient
     * @author lmh
     */
    public static function transfer(array $config = []): EcoTClient
    {
        return new EcoTClient($config);
    }



}