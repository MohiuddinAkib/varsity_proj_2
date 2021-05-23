<?php


namespace App\Facades;


use App\Contract\IPostService;
use Illuminate\Support\Facades\Facade;

class Post extends Facade
{
    protected static function getFacadeAccessor()
    {
        return IPostService::class;
    }
}
