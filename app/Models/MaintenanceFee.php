<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceFee extends Model
{
    use HasFactory;

    protected $fillable = [
        "reason",
        "expense_amount",
        "farm_id",
        "date_of_incident",
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}
