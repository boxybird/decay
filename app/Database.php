<?php

use SleekDB\Store;

class Database
{
    protected $store;

    public function __construct()
    {
        $this->store = new Store('movies', __DIR__.'/../database', [
            'timeout' => false
        ]);
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->store, $name], $arguments);
    }
}