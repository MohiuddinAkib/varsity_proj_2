<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        "cow_id",
        "condition",
        "note",
    ];

    public function cow()
    {
        return $this->belongsTo(Cow::class);
    }
}
