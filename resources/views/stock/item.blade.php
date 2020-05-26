@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <div class="row">
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

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
            
            
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <h3 align="center">Laravel Live Data Search with Sorting & Pagination using Ajax</h3><br />
            <div class="row">
                  <div class="col-md-9">

                  </div>
                  <div class="col-md-3">
                        <div class="form-group">
                              <input type="text" name="serach" id="serach" class="form-control" />
                        </div>
                  </div>
            </div>
            <div class="table-responsive">
                  <table class="table table-striped table-bordered">
                        <thead>
                              <tr>
                                    <th width="5%" class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">ID <span id="id_icon"></span></th>
                                    <th width="38%" class="sorting" data-sorting_type="asc" data-column_name="post_title" style="cursor: pointer">Title <span id="post_title_icon"></span></th>
                                    <th width="57%">Description</th>
                              </tr>
                        </thead>
                        <tbody>
                              @include('pagination_data')
                        </tbody>
                  </table>
                  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                  <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
                  <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
            </div>


<script>
      $(document).ready(function() {

            function clear_icon() {
                  $('#id_icon').html('');
                  $('#post_title_icon').html('');
            }

            function fetch_data(page, sort_type, sort_by, query) {
                  $.ajax({
                        url: "/pagination/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&query=" + query,
                        success: function(data) {
                              $('tbody').html('');
                              $('tbody').html(data);
                        }
                  })
            }

            $(document).on('keyup', '#serach', function() {
                  var query = $('#serach').val();
                  var column_name = $('#hidden_column_name').val();
                  var sort_type = $('#hidden_sort_type').val();
                  var page = $('#hidden_page').val();
                  fetch_data(page, sort_type, column_name, query);
            });

            $(document).on('click', '.sorting', function() {
                  var column_name = $(this).data('column_name');
                  var order_type = $(this).data('sorting_type');
                  var reverse_order = '';
                  if (order_type == 'asc') {
                        $(this).data('sorting_type', 'desc');
                        reverse_order = 'desc';
                        clear_icon();
                        $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
                  }
                  if (order_type == 'desc') {
                        $(this).data('sorting_type', 'asc');
                        reverse_order = 'asc';
                        clear_icon
                        $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
                  }
                  $('#hidden_column_name').val(column_name);
                  $('#hidden_sort_type').val(reverse_order);
                  var page = $('#hidden_page').val();
                  var query = $('#serach').val();
                  fetch_data(page, reverse_order, column_name, query);
            });

            $(document).on('click', '.pagination a', function(event) {
                  event.preventDefault();
                  var page = $(this).attr('href').split('page=')[1];
                  $('#hidden_page').val(page);
                  var column_name = $('#hidden_column_name').val();
                  var sort_type = $('#hidden_sort_type').val();

                  var query = $('#serach').val();

                  $('li').removeClass('active');
                  $(this).parent().addClass('active');
                  fetch_data(page, sort_type, column_name, query);
            });

      });
</script>




        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $("#code").blur(function() {
            var code = $('#code').val();
            // var last_name = $('#last_name').val();
            // var superior = $('#superior_list').val();                

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/itemExist',
                data: {
                    code: code
                },
                success: function(data) {
                    if (data == 0) {
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