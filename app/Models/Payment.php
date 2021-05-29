<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        "payment_cut",
        "payment_bonus",
        "worker_id",
        "payment_date",
        "payment_status",
        "payment_cut_reason",
        "payment_bonus_reason"
    ];

    public function worker()
    {
        return $this->belongsTo(User::class, "worker_id", "id");
    }
}
