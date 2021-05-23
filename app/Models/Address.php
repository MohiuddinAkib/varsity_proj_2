<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        "is_default" => "boolean"
    ];

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    /**
     * @return bool
     */
    public function getIsBillingAddressAttribute()
    {
        return $this->getAttributeFromArray("type") === "billing_address";
    }

    /**
     * @return bool
     */
    public function getIsShippingAddressAttribute()
    {
        return !$this->is_billing_address;
    }
}
