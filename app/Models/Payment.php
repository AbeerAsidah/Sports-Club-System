<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'subscription_id',
        'amount',
        'payment_date',
        'payment_method'
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
