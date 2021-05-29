<?php


namespace App\Facades;


use App\Contract\IMapService;
use Illuminate\Support\Facades\Facade;

class Map extends Facade
{
    protected static function getFacadeAccessor()
    {
        return IMapService::class;
    }
}
