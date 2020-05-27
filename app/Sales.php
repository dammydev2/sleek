<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = [
        'rec',
        'code',
        'description',
        'cost_price',
        'selling_price',
        'qty',
        'seller',
    ];
}
