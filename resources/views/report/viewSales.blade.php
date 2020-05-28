@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="container">
    <div class="row">

        <div class="col-lg-12" style="height: 30px"></div>
        <div class="col-lg-3"></div>

        <div class="panel panel-primary col-lg-4">
            <div class="panel-heading">Check sales</div>
            <div class="panel-body">

                <form method="post" action="{{ route('checkSales') }}">
                    @csrf

                    <div class="form-group has-feedback {{ $errors->has('from') ? ' has-error' : '' }}">
                        <label>Date From</label>
                        <input type="date" class="form-control" name="from" placeholder="Date From">
                        <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                        @if ($errors->has('from'))
                        <span class="help-block">
                            <strong>{{ $errors->first('from') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('to') ? ' has-error' : '' }}">
                        <label>Date To</label>
                        <input type="date" class="form-control" name="to" placeholder="Date To">
                        <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                        @if ($errors->has('to'))
                        <span class="help-block">
                            <strong>{{ $errors->first('to') }}</strong>
                        </span>
                        @endif
                    </div>

                    <input type="submit" class="btn btn-primary btn-block" value="Continue">

                </form>

            </div>
        </div>


    </div>
</div>
@endsection