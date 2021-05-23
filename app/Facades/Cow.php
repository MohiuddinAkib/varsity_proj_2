<?php


namespace App\Facades;


use App\Contract\ICowService;
use Illuminate\Support\Facades\Facade;

class Cow extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ICowService::class;
    }
}
