@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="container">
    <div class="row">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="{{ URL::asset('js/ajax.js') }}"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <style type="text/css">
            div.resultdata div:hover {
                background-color: #e1e1e1;
            }
        </style>

        <div class="col-sm-10">
            <!-- <h3 align="center">Drug Live search </h3><br /> -->
            <div class="panel panel-default">
                @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif
                <div class="panel-heading">Search Item</div>
                <div class="panel-body">
                    <a href="" class="btn btn-danger">Reset All</a>
                    <div class="myrespons"></div>
                    <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search Drugs" style="border-radius: 5px 5px 0 0;" />
                        <div class="col-sm-12 resultdata" style="padding: 5px;border: 1px solid #e1e1e1;border-top: none;display: none;">

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <h3 align="center">Total Data : <span id="total_records"></span></h3>
                        <form method="post" action="{{ route('saleEnter') }}" id="form1">
                            {{ csrf_field() }}

                            <table class="table table-striped table-bordered items">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Cost Price</th>
                                        <th>Selling Price</th>
                                        <th>Current Stock</th>
                                        <th>Qty</th>
                                        <th>Amount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-right">Total</th>
                                        <th colspan="2">&#8358;<span class="total">0.00</span></th>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="submit" name="" value="continue" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <script type="text/javascript">
            var form1 = document.getElementById('form1');
            form1.onsubmit = function(e) {
                var form = this;
                e.preventDefault();
                if (confirm("Are you sure you wish to submit? You cant undo"))
                    form.submit();
            }
        </script>

        <script>
            var added = [];
            $(document).ready(function() {

                fetch_customer_data();

                function fetch_customer_data(query = '') {
                    $.ajax({
                        url: "{{ route('live_search.action') }}",
                        method: 'GET',
                        data: {
                            query: query
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.total_data > 0) {
                                $(".myrespons").html("");
                                $("div.resultdata").slideDown();
                                $('div.resultdata').html(data.table_data);
                            } else {
                                $(".myrespons").html("<div class='alert alert-danger'>No Data Found</div>");
                            }
                            $('#total_records').text(data.total_data);
                        }
                    })
                }

                $(document).on("click", "div.rst", function() {
                    el = $(this);

                    name = el.text();
                    if (added.indexOf(name) > -1) {
                        $("div.resultdata").slideUp();
                        $("div.resultdata").html("");
                        $("input#search").val("");
                    } else {
                        price = el.data("price")
                        description = el.data("description")
                        current_stock = el.data("current_stock")
                        code = el.data("code")
                        percent = price * 0.1;
                        amt = price - percent;
                        // qty2 = el.data("qty2")
                        // stockid = el.data("id")

                        $("div.resultdata").slideUp();
                        $("div.resultdata").html("");
                        $("input#search").val("");

                        tdata = "<tr>"

                        tdata += "<td>" + code + "<input type='hidden' name='code[]' value='" + code + "' class='form-control'/></td>"
                        tdata += "<td>" + description + "<input type='hidden' name='description[]' value='" + description + "' class='form-control'/></td>"
                        tdata += "<td>" + price + "<input type='hidden' name='cost_price[]' value='" + price + "' class='form-control'/></td>"
                        tdata += "<td><input class='form-control sellingPrice' type='hidde' name='selling_price[]' /></td>"
                        tdata += "<td>" + current_stock + "</td></td>"
                        tdata += "<td><input type='number' name='qty[]' min='1' value='0' class='form-control qty'/></td>"
                        // tdata += "<td>"+percent+"<input type='hidden' name='percent[]' value='"+percent+"' class='form-control qty'/></td>"
                        tdata += "<td>&#8358;<span class='tamount'>" + price + "</span></td>"
                        // tdata += "<td>&#8358;<span class='tamount'>"+amt+"</span><input type='hidden' name='amount[]' value='"+amt+"' /></td>"
                        tdata += "<td><a href='#' class='btn btn-danger btn-xs rm'><i class='fa fa-trash'></i></a></td>"
                        tdata += "</tr>";
                        $("table.items tbody").append(tdata);
                        added.push(name);
                        sumup()
                    }
                })

                $(document).on("click", "a.rm", function() {

                    txt = $(this).parents("tr").find("td:first").text()
                    $(this).parents("tr").remove();
                    ind = added.indexOf(txt);
                    added.splice(ind, 1)
                    sumup();

                })

                $(document).on("change", "input.qty", function() {
                    v = $(this).val();
                    prc = parseInt($(this).parents("tr").find("input.sellingPrice").val())
                    

                    tamt = prc * v
                    console.log(tamt)
                    $(this).parents("tr").find("span.tamount").html(tamt);
                    sumup()
                })

                $(document).on('keyup', '#search', function() {
                    if ($(this).val() == "") {
                        $("div.resultdata").slideUp();
                    }
                    var query = $(this).val();
                    fetch_customer_data(query);
                });
            });

            function sumup() {
                len = $("span.tamount").length
                sum = 0;
                for (a = 0; a < len; a++) {
                    v = parseInt($("span.tamount:eq(" + a + ")").text());
                    sum += v
                }

                $("tfoot span.total").html(sum);
            }
        </script>


    </div>
</div>

@endsection