<?php

namespace App\Models;

use Map;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Farm extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "location",
        "contact_number",
        "owner_id",
        "establish_date",
        "latitude",
        "longitude",
    ];

    protected $casts = [
        "established_at" => "date",
        "closed_at" => "date",
    ];

    public function employees()
    {
        return $this->hasMany(User::class);
    }

    public function localadmin()
    {
        return $this->belongsTo(User::class, "ladmin_id", "id");
    }

    public function owner()
    {
        return $this->belongsTo(User::class, "owner_id", "id");
    }

    protected static function booted()
    {
        parent::booted();

        self::creating(function(Farm $model) {
            $response = Map::geocode_from_location($model->location);
//            dd($response);
            $model->latitude = 0;
            $model->longitude = 0;
        });
    }
}
