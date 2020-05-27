<?php

namespace App\Services;

use DB;
use App\User;
use App\Item;
use Session;
use Hash;

class StockService
{
    protected $user, $item;
    public function __construct(User $user, Item $item)
    {
        $this->user = $user;
        $this->item = $item;
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

    

}