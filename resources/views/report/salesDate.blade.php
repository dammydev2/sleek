@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="container">
    <div class="row">

        <div class="col-lg-12" style="height: 30px"></div>
        <div class="col-lg-1"></div>

        <div class="panel panel-primary col-lg-10">
            <div id="printPageButton" class="panel-heading">Sales from {{ Session::get('from') }} to {{ Session::get('to') }}</div>
            <div class="panel-body">
                <div id="printPageButton">
                    <button onclick="exportTableToExcel('tblData', 'profit-margin')" class="btn btn-warning">Excel</button>
                    <input type="button" id="btnExport" value="PDF" class="btn btn-success" onclick="Export()" />
                    <input type="button" value="Print" class="btn btn-info" onclick="window.print()" />
                </div>
                <table id="tblData" class="table table-bordered table-responsive table-striped">
                    <tr>
                        <th colspan="7">
                            <center>Sales from {{ Session::get('from') }} to {{ Session::get('to') }}</center>
                        </th>
                    </tr>
                    <tr>
                        <th>Date/Time</th>
                        <th>Cutomer Name</th>
                        <th>Item</th>
                        <th>Sale Unit Price</th>
                        <th>Qty</th>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                    </tr>
                    <?php $sum = 0; $totalQty = 0; ?>
                    @foreach($data as $row)
                    <tr>
                        <?php
$customer = DB::table('payments')->where('rec', $row->rec)->first();

                        ?>
                        <td>{{ $row->created_at }}</td>
                        <td>{{ $customer->customer_name }}</td>
                        <td>{{ $row->code. ' '.$row->description }}</td>
                        <td class="text-right">{{ $row->selling_price }}</td>
                        <td>{{ $row->qty }}</td>
                        <td class="text-right">{{ $costPrice = $row->qty * $row->cost_price }}</td>
                        <td class="text-right">{{ $sellingPrice = $row->qty * $row->selling_price }}</td>
                        <?php 
                        $sum += $sellingPrice;
                        $totalQty += $row->qty;
                        ?>
                    </tr>
                    @endforeach
                    <tr>
                        <th class="text-right" colspan="3">Total Quantity of Goods sold</th>
                        <th class="text-right">{{ $totalQty }}</th>
                        <th class="text-right" colspan="1">Total Sales</th>
                        <th class="text-right">{{ number_format($sum, 2) }}</th>
                    </tr>
                </table>

            </div>
        </div>


    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script type="text/javascript">
    function Export() {
        html2canvas(document.getElementById('tblData'), {
            onrendered: function(canvas) {
                var data = canvas.toDataURL();
                var docDefinition = {
                    content: [{
                        image: data,
                        width: 500
                    }]
                };
                pdfMake.createPdf(docDefinition).download("Profit-margin.pdf");
            }
        });
    }
</script>
<script>
    function exportTableToExcel(tableID, filename = '') {
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

        // Specify file name
        filename = filename ? filename + '.xls' : 'excel_data.xls';

        // Create download link element
        downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        if (navigator.msSaveOrOpenBlob) {
            var blob = new Blob(['\ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

            // Setting the file name
            downloadLink.download = filename;

            //triggering the function
            downloadLink.click();
        }
    }
</script>
<style>
    @media print {
        #printPageButton {
            display: none;
        }
    }
</style>
@endsection