<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 17:45
 */

namespace App\Commons\Helpers;


class ServiceHelper
{
    protected $service;

    protected $type;

    protected $action;

    public function __construct($service)
    {
        $this->service = 'App\Services\\'.$service;
    }

    public static function make($service)
    {
        return new self($service);
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        $args = [$name, $arguments[0] ?? null, $this->type, $this->action];
        $idx = count($args);

        for ($i = count($args) - 1; $i > 0; $i--) {
            if ($args[$i] !== null) {
                break;
            }

            $idx = $i;
        }

        $args = array_slice($args, 0, $idx);

        return $this->call(...$args);
    }

    public function call($method,$data = null, $type = 'get', $path = null)
    {
        $ob = app($this->service);
        return $ob->$method($data);
    }
}