<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Services\StockService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $stockService;
    public function __construct(StockService $stockService)
    {
        $this->middleware('auth');
        $this->stockService = $stockService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function item()
    {
        $item = $this->stockService->allItems();
        return view('stock.item', compact('item'));
    }

    public function addItem(Request $request)   
    {
        $request->validate([
            'code' => 'required|unique:items',
            'description' => 'required',
        ]);
        $this->stockService->enterItem($request->all());
        return redirect()->back()->with('success', 'Item added successfully');  
    }

    public function itemExist(Request $request){
        return Item::where('code', $request->code)->first();
    }


}






