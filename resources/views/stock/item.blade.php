@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
	<div class="row">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Modal Header</h4>
					</div>
					<div class="modal-body">

						<form method="POST" id="item_form" action="{{ route('addItem') }}">
							@csrf

							<div class="form-group">
								<label for="usr">Item Code:</label>
								<input type="text" id="code" required="" name="code" class="form-control" id="usr">
							</div>

							<div class="form-group">
								<label>Description</label>
								<textarea class="form-control" required="" name="description"></textarea>
							</div>

							<input type="submit" class="btn btn-primary btn-block" value="Add Item">

						</form>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</div>
		</div>
		<!-- modal ends -->

	@if(Session::has('success'))
	<div class="alert alert-success">{{ Session::get('success') }}</div>
	@endif

	<div class="col-md-8">
		<h4>All Stocks</h4>
	{{ $item->links() }}
		<table class="table table-striped table-responsive table-bordered">
			<tr>
				<td colspan="5"><center><!-- Trigger the modal with a button -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add new Code <i class="fa fa-plus"></i></button></center></td>
			</tr>
			<tr>
				<th>Code</th>
				<th>Description</th>
				<th>Current Stock</th>
				<th></th>
				<th></th>
			</tr>
			@foreach($item as $items)
			<tr>
				<td>{{ $items->code }}</td>
				<td>{{ $items->description }}</td>
				<td>{{ $items->current_stock }}</td>
			</tr>
			@endforeach
		</table>
		{{ $item->links() }}
	</div>

	</div>
</div>

<script>
$(document).ready(function(){
	$("#code").blur(function(){
        var code = $('#code').val();
        // var last_name = $('#last_name').val();
        // var superior = $('#superior_list').val();                

        $.ajax({
			headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
                type: 'POST',
                url: '/itemExist',
                data: {code: code},
                success: function(data){
                   if(data == 0){
                      // alert('nothing');
                   } else {
                       alert('the code already exists!');
                   }
                } 
            });

    });
});
</script>
@endsection
