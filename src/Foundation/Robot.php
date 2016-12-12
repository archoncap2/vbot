<?php
/**
 * Created by PhpStorm.
 * User: Hanson
 * Date: 2016/12/9
 * Time: 21:22
 */

namespace Hanson\Robot\Foundation;


use Hanson\Robot\Core\Http;
use Illuminate\Support\Collection;
use Pimple\Container;

class Robot extends Container
{

    /**
     * Service Providers.
     *
     * @var array
     */
    protected $providers = [
        ServiceProviders\ServerServiceProvider::class,
    ];

    public function __construct($config)
    {
        parent::__construct();

        $this['config'] = function () use ($config) {
            return new Collection($config);
        };

        $this->registerProviders();
    }

    /**
     * Register providers.
     */
    private function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->register(new $provider());
        }
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed  $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }
}