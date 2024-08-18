<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_percentage',
        'start_date',
        'end_date'
    ];

    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class, 'offer_subscription');
    }
}
