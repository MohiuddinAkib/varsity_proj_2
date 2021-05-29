<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cow extends Model
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $dates = ["dob"];

    protected $fillable = [
        "breed_id",
        "farm_id",
        "weight",
        "type",
        "gender",
        "description",
        "dob",
        "is_marked_for_sale",
        "is_sold",
    ];

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function getAgeAttribute()
    {
        return $this->dob->age;
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->name = Str::uuid();
        });
    }
}
