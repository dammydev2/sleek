<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'rec',
        'amount',
        'amount_tendered',
        'change',
        'customer_name',
        'payment_method',
        'seller',
    ];
}
