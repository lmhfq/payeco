<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/22
 * Time: 下午2:36
 */

namespace Lmh\Payeco;


use Illuminate\Support\Str;

/**
 * Class Factory
 * @package Lmh\Payeco
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/22
 * @method static Service\Transfer\Application    transfer(array $config)
 * @method static Service\Transaction\Application    transaction(array $config)
 */
class Factory
{

    /**
     * @param string $name
     * @param array $config
     * @return mixed
     * @author lmh
     */
    public static function make(string $name, array $config)
    {
        $namespace = Str::studly($name);
        $application = "\\Lmh\\Payeco\\Service\\{$namespace}\\Application";
        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return self::make($name, ...$arguments);
    }
}