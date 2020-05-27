@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-lg-12" style="height: 30px"></div>
        <div class="col-lg-3"></div>

        <div class="panel panel-primary col-lg-4">
            <div class="panel-heading">Add more stock to {{ $stock->code }}</div>
            <div class="panel-body">

                <form method="post" action="">
                    @csrf
                    <div class="form-group">
                        <label for="usr">Item Code:</label>
                        <input type="text" id="code" readonly value="{{ $stock->code }}" required="" name="code" class="form-control" id="usr">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" readonly required="" name="description">{{ $stock->description }}</textarea>
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('cost_price') ? ' has-error' : '' }}">
                        <input type="number" class="form-control" name="cost_price" value="{{ $stock->cost_price }}" placeholder="Cost Price">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('cost_price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cost_price') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="usr">Currently in store:</label>
                        <input type="text" id="code" readonly value="{{ $stock->current_stock }}" required="" name="current_stock" class="form-control" id="usr">
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('new_stock') ? ' has-error' : '' }}">
                        <input type="number" class="form-control" name="new_stock" value="{{ $stock->new_stock }}" placeholder="New Stock">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('new_stock'))
                        <span class="help-block">
                            <strong>{{ $errors->first('new_stock') }}</strong>
                        </span>
                        @endif
                    </div>

                </form>

            </div>
        </div>


    </div>
</div>
@endsection