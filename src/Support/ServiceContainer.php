<?php
declare(strict_types=1);


namespace Lmh\Payeco\Support;

use Lmh\Payeco\Provider\ConfigServiceProvider;
use Pimple\Container;

class ServiceContainer extends Container
{
    /**
     * @var array
     */
    protected $userConfig = [];
    /**
     * @var array
     */
    protected $providers = [];


    public function __construct(array $config = [], array $prepends = [])
    {
        parent::__construct($prepends);

        $this->userConfig = $config;

        $this->registerProviders($this->getProviders());
    }

    /**
     * Return all providers.
     *
     * @return array
     */
    public function getProviders(): array
    {
        return array_merge([
            ConfigServiceProvider::class,
        ], $this->providers);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $base = [
            'http' => [
                'timeout' => 60.0,
                'base_uri' => 'https://agent.payeco.com/service',
            ],
            'debug' => false,
            'log' => [
                'name' => 'payeco',
                'path' => '/tmp/payeco.log',
                'level' => 'debug',
            ],
            'userName' => '',
            'keystoreFilename' => '',
            'keystorePassword' => '',
            'keyContent' => '',
            'certificateFilename' => '',
            'certContent' => '',
            'platformCertContent' => '',//平台公钥
        ];
        if (isset($this->userConfig['sandbox']) && $this->userConfig['sandbox'] == true) {
            $base['http']['base_uri'] = 'https://testagent.payeco.com:9444/service';
        }
        return array_replace_recursive($base, $this->userConfig);
    }

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }
}