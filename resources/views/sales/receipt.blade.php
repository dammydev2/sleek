@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="container">
    <div class="row">

        <div class="col-lg-12" style="height: 30px"></div>
        <div class="col-lg-3">
            <a href="#" onclick="window.print()" id="printPageButton" class="btn btn-default">Print <i class="fa fa-print"></i></a>
        </div>

        <div class="rec col-lg-4">
            <center class="text-bold">Sleek Clothing & Accessories</center>
            <p>
                <center>Suite x, Block Y, Alausa Shopping Mall,<br> 131
                    Obafemi Awolowo Way, Ikeja, Lagos <br> 08080000000</center>
            </p>
            <p>{{ date('d-M-Y h:i:s A') }} <span class="text-right">{{ $paymentDetails->customer_name }}</span>
                <br>Receipt no: <b>{{ $paymentDetails->rec }}</b> <span class="text-right">Payment Mode: {{ $paymentDetails->payment_method }}</span>

                <table border="0">
                    <tr>
                        <th>Qty</th>
                        <th>Item</th>
                        <th>Rate</th>
                        <th>Cost</th>
                    </tr>
                    <?php $sum = 0; ?>
                    @foreach($detail as $details)
                    <tr>
                        <td>{{ $details->qty }}</td>
                        <td>{{ $details->code. ' '.$details->description }}</td>
                        <td>{{ number_format($details->selling_price, 2) }}</td>
                        <td>{{ number_format($amount = $details->selling_price * $details->qty, 2) }}</td>
                    </tr>
                    <?php $sum += $amount; ?>
                    @endforeach
                    <tr>
                        <th colspan="3">GRAND TOTAL:</th>
                        <th>{{ number_format($sum, 2) }}</th>
                    </tr>
                </table>
                <P style="border: 1px solid #000;"></P>
                <p><i>Goods sold in good conditions are not returnable<br>
                        Satisfied with us, tell others, if not tell us</i></p>
                <p>You have been served by: {{ \Auth::User()->name }}</p>
        </div>


    </div>
</div>

<style>
    .rec {
        border: 1px solid #000;
    }

    .text-right {
        float: right;
    }

    td,
    th {
        padding: 3px;
        font-size: 11px;
    }

    @media print {
        #printPageButton {
            display: none;
        }
    }
</style>

@endsection