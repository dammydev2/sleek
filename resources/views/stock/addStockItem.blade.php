@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="container">
    <div class="row">

        <div class="col-lg-12" style="height: 30px"></div>
        <div class="col-lg-3"></div>

        <div class="panel panel-primary col-lg-4">
            <div class="panel-heading">Add more stock to {{ $stock->code }}</div>
            <div class="panel-body">

                <form method="post" action="{{ route('enterStock') }}">
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
                        <input type="text" id="inStock" readonly value="{{ $stock->current_stock }}" required="" name="current_stock" class="form-control">
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('new_stock') ? ' has-error' : '' }}">
                        <input type="number" id="newStock" class="form-control" name="new_stock" value="{{ old('new_stock') }}" placeholder="New Stock">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('new_stock'))
                        <span class="help-block">
                            <strong>{{ $errors->first('new_stock') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="usr">Total Stock Now:</label>
                        <input type="text" id="total" readonly required="" name="total" class="form-control">
                    </div>

                    <input type="submit" class="btn btn-primary btn-block" value="Add new Stock">

                </form>

            </div>
        </div>


    </div>
</div>

<script>
    $(document).ready(function() {
        var sum = parseInt($("#inStock").val()) + parseInt($("#newStock").val());
        // Assign sum to third textbox
        $("#total").val(sum);
        
        $("#newStock").keyup(function() {
            var sum = parseInt($("#inStock").val()) + parseInt($("#newStock").val());
            // Assign sum to third textbox
            $("#total").val(sum);
        });
    });
</script>
@endsection