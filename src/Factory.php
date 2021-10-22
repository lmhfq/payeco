<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/22
 * Time: 下午2:36
 */

namespace Lmh\Payeco;


use Lmh\Payeco\Service\Transfer\Application;

class Factory
{
    /**
     * @param array $config
     * @return Application
     * @author lmh
     */
    public static function transfer(array $config = []): Application
    {
        return new Application($config);
    }

}