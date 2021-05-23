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
        "city",
        "area",
        "region",
        "address",
        "closed_at",
        "established_at",
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
        return $this->hasOne(User::class)->role("localadmin");
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the post's image.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
