<?php

namespace App\Services;

use DB;
use App\User;
use App\Item;
use App\AddStock;
use Session;
use Hash;

class StockService
{
    protected $user, $item, $addStock;
    public function __construct(User $user, Item $item, AddStock $addStock)
    {
        $this->user = $user;
        $this->item = $item;
        $this->addStock = $addStock;
    }

    public function allItems()
    {
        return $this->item->orderBy('code', 'asc')->paginate(30);
    }

    public function enterItem(array $credentials)
    {
        return $this->item->insert([
            'code' => $credentials['code'],
            'description' => $credentials['description'],
        ]);
    }

    public function itemDelete($id)
    {
        return $this->item->where('id',$id)->delete();
    }

    public function getCurrentStock($id)
    {
        return $this->item->where('id',$id)->first();
    }

    public function addNewStock(array $credentials)
    {
        $this->item->where('code', $credentials['code'])->update([
            'current_stock' => $credentials['total'],
            'cost_price' => $credentials['cost_price'],
        ]);
        return $this->addStock->create([
            'code' => $credentials['code'],
            'stock' => $credentials['new_stock'],
            'cost_price' => $credentials['cost_price'],
        ]);
    }

    

}