<?php


namespace App\Facades;


use App\Contract\IFarmService;
use Illuminate\Support\Facades\Facade;

class Farm extends Facade
{
    protected static function getFacadeAccessor()
    {
        return IFarmService::class;
    }
}
