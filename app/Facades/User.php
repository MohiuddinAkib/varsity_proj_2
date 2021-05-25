<?php


namespace App\Facades;


use App\Contract\IUserService;
use Illuminate\Support\Facades\Facade;

class User extends Facade
{
    protected static function getFacadeAccessor()
    {
        return IUserService::class;
    }
}
