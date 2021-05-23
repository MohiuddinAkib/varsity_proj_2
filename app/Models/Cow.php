<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Cow extends Model
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $fillable = [
        "name",
        "extras",
        "description",
        "dob",
        "farm_id",
        "breed_id",
        "gender",
    ];
}
