<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "email",
        "password",
        "farm_id"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "password",
        "remember_token",
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "email_verified_at" => "datetime",
    ];

    public function getFullnameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Set the user's password.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes["password"] = bcrypt($value);
    }

    public function providers()
    {
        return $this->hasMany("App\Models\Provider");
    }

    /**
     * Get the profile for the user.
     */
    public function profile()
    {
        return $this->hasOne("App\Models\Profile");
    }

    public function addresses()
    {
        return $this->hasMany("App\Models\Address");
    }

    public function farm()
    {
        return $this->belongsTo("App\Models\Farm");
    }


    public function image()
    {
        return $this->hasOneThrough(Image::class, Profile::class, "user_id", "imageable_id")
            ->where('imageable_type', Profile::class);
    }
}
