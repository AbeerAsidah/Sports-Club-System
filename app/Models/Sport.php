<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'schedule'];

    protected $casts = [
        'schedule' => 'array', // Casting JSON field to array
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }

    public function images()
    {
        return $this->hasMany(SportImage::class);
    }

    public function videos()
    {
        return $this->hasMany(SportVideo::class);
    }

}
