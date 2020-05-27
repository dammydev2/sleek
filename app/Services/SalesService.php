<?php

namespace App\Services;

use DB;
use App\User;
use App\Item;
use App\AddStock;
use Session;
use Hash;

class SalesService
{
    protected $user, $item, $addStock;
    public function __construct(User $user, Item $item, AddStock $addStock)
    {
        $this->user = $user;
        $this->item = $item;
        $this->addStock = $addStock;
    }

    public function getAllItem()
    {
        return $this->item->all();
    }

    public function enterSales(array $credentials)
    {
        dd($credentials);
    }

}