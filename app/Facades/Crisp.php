<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Crisp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'crisp';
    }
}