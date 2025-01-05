<?php

namespace App;

use SleekDB\Store;

require_once __DIR__.'/../vendor/autoload.php';

abstract class Database
{
    protected $store;

    public function __construct()
    {
        $class_name = get_called_class();
        $class_name = explode('\\', $class_name);

        $store_name = strtolower(end($class_name));

        $this->store = new Store($store_name, __DIR__.'/../database', [
            'timeout' => false
        ]);
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->store, $name], $arguments);
    }
}