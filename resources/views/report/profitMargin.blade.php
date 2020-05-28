@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="container">
    <div class="row">

        <div class="col-lg-12" style="height: 30px"></div>
        <div class="col-lg-1"></div>

        <div class="panel panel-primary col-lg-10">
            <div id="printPageButton" class="panel-heading">Profit Margin from {{ Session::get('from') }} to {{ Session::get('to') }}</div>
            <div class="panel-body">
                <div id="printPageButton">
                    <button onclick="exportTableToExcel('tblData', 'profit-margin')" class="btn btn-warning">Excel</button>
                    <input type="button" id="btnExport" value="PDF" class="btn btn-success" onclick="Export()" />
                    <input type="button" value="Print" class="btn btn-info" onclick="window.print()" />
                </div>
                <table id="tblData" class="table table-bordered table-responsive table-striped">
                    <tr>
                        <th colspan="7">
                            <center>Profit Margin from {{ Session::get('from') }} to {{ Session::get('to') }}</center>
                        </th>
                    </tr>
                    <tr>
                        <th>Date/Time</th>
                        <th>Item</th>
                        <th>Sale Unit Price</th>
                        <th>Qty</th>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        <th>Profit Margin</th>
                    </tr>
                    <?php $sum = 0; ?>
                    @foreach($data as $row)
                    <tr>
                        <td>{{ $row->created_at }}</td>
                        <td>{{ $row->code. ' '.$row->description }}</td>
                        <td class="text-right">{{ $row->selling_price }}</td>
                        <td>{{ $row->qty }}</td>
                        <td class="text-right">{{ $costPrice = $row->qty * $row->cost_price }}</td>
                        <td class="text-right">{{ $sellingPrice = $row->qty * $row->selling_price }}</td>
                        <td class="text-right">{{ number_format($profit = $sellingPrice - $costPrice, 2) }}</td>
                        <?php $sum += $profit ?>
                    </tr>
                    @endforeach
                    <tr>
                        <th class="text-right" colspan="6">Profit Margin</th>
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