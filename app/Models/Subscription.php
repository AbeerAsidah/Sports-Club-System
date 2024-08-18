<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'start_date',
        'end_date',
        'status',
        'suspension_reason',
        'subscription_duration'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_subscription');
    }
}
