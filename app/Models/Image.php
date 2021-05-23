<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    protected $fillable = ["url"];

    use HasFactory, SoftDeletes;

    public function imageable()
    {
        return $this->morphTo();
    }
}
