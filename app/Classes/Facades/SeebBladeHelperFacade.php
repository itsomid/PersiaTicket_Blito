<?php

namespace App\Classes\Seeb\Facades;
use Illuminate\Support\Facades\Facade;

class SeebBladeHelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SeebBlade';
    }
}