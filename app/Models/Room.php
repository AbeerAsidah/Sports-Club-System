<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sport_id', 'facility_id'];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
