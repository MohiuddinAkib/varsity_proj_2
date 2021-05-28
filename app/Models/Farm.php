<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Farm extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "location",
        "contact_number",
        "owner_id",
        "establish_date",
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
}
