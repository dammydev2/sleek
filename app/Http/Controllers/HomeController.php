<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Services\StockService;
use DB;
use Datatables;

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

    public function item(Request $request)
    {
        // $item = $this->stockService->allItems();
        // return view('stock.item', compact('item'));

        $data = DB::table('items')->orderBy('id', 'asc')->paginate(20);
        return view('stock.item', compact('data'));
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $data = DB::table('items')
                ->where('id', 'like', '%' . $query . '%')
                ->orWhere('code', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->orderBy($sort_by, $sort_type)
                ->paginate(20);
            return view('pagination_data', compact('data'))->render();
        }
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

    public function itemExist(Request $request)
    {
        return Item::where('code', $request->code)->first();
    }

    public function deleteItem($id)
    {
        $this->stockService->itemDelete($id);
        return redirect()->back()->with('error', 'Item deleted successfully');
    }

    public function addStockItem($id)
    {
        $stock = $this->stockService->getCurrentStock($id);
        return view('stock.addStockItem', compact('stock'));
    }

    public function enterStock(Request $request)
    {
        $request->validate([
            'cost_price' => 'required',
            'new_stock' => 'required'
        ]);
        $this->stockService->addNewStock($request->all());
        return redirect('item')->with('success', 'Stock added successfully');
    }

    
}
