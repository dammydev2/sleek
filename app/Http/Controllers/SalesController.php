<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SalesService;
use App\Item;

class SalesController extends Controller
{
    protected $alesService;
    public function __construct(SalesService $salesService)
    {
        $this->middleware('auth');
        $this->salesService = $salesService;
    }

    public function sales()
    {
        $data = $this->salesService->getAllItem();
        return view('sales.index', compact('data'));
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = Item::where('code', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%'.$query.'%')
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $data = DB::table('items')
                    ->orderBy('code', 'asc')
                    ->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
          <div class="col-sm-12 rst"
          data-price = "' . $row->cost_price . '"
          data-code = "' . $row->code . '"
          data-current_stock = "' . $row->current_stock . '"
          data-description = "' . $row->description . '"
          data-id = "' . $row->id . '"
          style="cursor:pointer;"
          >' . $row->code . ' (' . $row->description . ')</div>';
                }
            } else {
                $output = '
       <tr>
       <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }

    public function saleEnter(Request $request)
    {
        $rec = $this->salesService->enterSales($request->all());
    }
}
