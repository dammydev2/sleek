<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddStock extends Model
{
    protected $fillable = [
        'code',
        'stock',
        'cost_price',
    ];
}
