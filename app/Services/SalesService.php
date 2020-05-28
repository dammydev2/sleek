<?php

namespace App\Services;

use DB;
use App\User;
use App\Item;
use App\AddStock;
use App\Sales;
use Session;
use Hash;
use Illuminate\Contracts\Session\Session as SessionSession;

class SalesService
{
    protected $user, $item, $addStock, $sales;
    public function __construct(User $user, Item $item, AddStock $addStock, Sales $sales)
    {
        $this->user = $user;
        $this->item = $item;
        $this->addStock = $addStock;
        $this->sales = $sales;
    }

    public function getAllItem()
    {
        return $this->item->all();
    }

    public function enterSales(array $credentials)
    {
        $getID = $this->sales->select('rec')->orderBy('id', 'desc')->first();
        if ($getID === NULL) {
            $oldRec = 1000;
        } else {
            $oldRec = $getID->rec;
        }
        $newRec = $oldRec + 1;
        $num = count($credentials['qty']);
        //dd($credentials);
        for ($i = 0; $i < $num; $i++) {
            //updating stock
            $code = $credentials['code'][$i];
            $newStock = $credentials['newStock'][$i];
            DB::table('items')->where('code', $code)
                ->update(array('current_stock' => $newStock));
            // updating stock
            $this->sales->create([
                'rec' => $newRec,
                'code' => $credentials['code'][$i],
                'description' => $credentials['description'][$i],
                'cost_price' => $credentials['cost_price'][$i],
                'selling_price' => $credentials['selling_price'][$i],
                'qty' => $credentials['qty'][$i],
                'seller' => \Auth::User()->name
            ]);
        }
        return Session::put('rec', $newRec);
    }

    public function getSaleDetails()
    {
        $rec = $this->sales->where('rec', Session::get('rec'))->get();
        $amount = 0;
        foreach ($rec as $row) {
            $amount += $row->selling_price * $row->qty;
        }
        return $amount;
    }
}
