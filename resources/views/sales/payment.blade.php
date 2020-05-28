@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="container">
    <div class="row">

        <div class="col-lg-12" style="height: 30px"></div>
        <div class="col-lg-3"></div>

        <div class="panel panel-primary col-lg-4">
            <div class="panel-heading">Payment</div>
            <div class="panel-body">

                <form method="post" action="{{ route('enterPayment') }}">
                    @csrf
                    <div class="form-group">
                        <label for="usr">Receipt Number</label>
                        <input type="text" id="code" readonly value="{{ Session::get('rec') }}" required="" name="rec" class="form-control" id="usr">
                    </div>

                    <div class="form-group">
                        <label for="usr">Amount to be paid</label>
                        <input type="text" id="amount" readonly value="{{ $detail }}" required="" name="amount" class="form-control" id="usr">
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('amount_tendered') ? ' has-error' : '' }}">
                        <label>Amount Tendered</label>
                        <input type="number" id="amount_tendered" class="form-control" name="amount_tendered" placeholder="Amount Tendered">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('amount_tendered'))
                        <span class="help-block">
                            <strong>{{ $errors->first('amount_tendered') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="usr">Change:</label>
                        <input type="text" id="change" readonly required="" name="change" class="form-control">
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('customer_name') ? ' has-error' : '' }}">
                        <label>Customer Name</label>
                        <input type="text" class="form-control" name="customer_name" value="Walk-In customer" placeholder="customer name">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('customer_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('customer_name') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="usr">Payment Method:</label>
                        <select class="form-control" name='payment_method'>
                            <option>Cash</option>
                            <option>POS</option>
                            <option>Transfer</option>
                        </select>
                    </div>

                    <input type="submit" class="btn btn-primary btn-block" value="Continue">

                </form>

            </div>
        </div>


    </div>
</div>

<script>
        $("#amount_tendered").keyup(function() {
            var sum = parseInt($("#amount_tendered").val()) - parseInt($("#amount").val());
            // Assign sum to third textbox
            $("#change").val(sum);
        });
</script>
@endsection