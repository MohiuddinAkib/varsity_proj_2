<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cow extends Model
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $dates = ["dob"];

    protected $fillable = [
        "name",
        "extras",
        "description",
        "dob",
        "farm_id",
        "breed_id",
        "gender",
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
            $model->name = IdGenerator::generate(['table' => $this->table, 'length' => 10, 'prefix' => "COW-"]);
        });
    }
}
