@extends('layouts.master')
@section('title')
    Flomuvina | Trade
@endsection
@section('link')
    <link
        href="{{ URL::to('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
        rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Inventory</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Inventory</li>
                        <li class="breadcrumb-item active">Purchase</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal"
                        id="addTradeBtn">
                        <i class="fa fa-plus-circle"></i> Create New </button>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="trade-table" class="table m-t-30 table-hover no-wrap contact-list" data-paging="true"
                                data-paging-size="7">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Commodity</th>
                                        <th>Qty</th>
                                        <th>Price(kg)</th>
                                        <th>Amount</th>
                                        <th>Warehouse</th>
                                        <th>Farmer Name</th>
                                        <th>Farmer Phone </th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot></tfoot>
                                @include('pricing.add')

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->

    </div>
@endsection
@section('script')
    <script
        src="{{ URL::to('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
    </script>

    <script>
        $(function() {
            $("#create_trade_form").on('submit', function(e) {
                e.preventDefault();
                $("#btnSubmit").css('display', 'none');
                $("#loading").css('display', 'inline');
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {
                        $("#loading").css('display', 'none');
                        $("#btnSubmit").css('display', 'inline');
                        if (data.status == 1) {
                            $('#trade-table').DataTable().ajax.reload(null, false);
                            $('#create_trade_form')[0].reset();
                            $('#add-trade-modal').modal('hide');
                        } else if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            $('span.error_message').text(data.msg);
                        }
                    }
                });
            });

            $(document).on('click', '#addTradeBtn', function() {
                $('#create_trade_form')[0].reset();
                $('#add-trade-modal').modal('show');
            });
            $(document).on('click', '#editTradeBtn', function() {
                var id = $(this).data('id');
                $('#update_trade_form')[0].reset();
                $(document).find('span.error-text').text('');
                $('#edit-trade-modal').modal('show');
                $.get("{{ url('/trade/edit/') }}" + '/' + id, function(data) {
                    $('input[name="id"]').val(data.details.id);
                    $('input[name="end_date"]').val(data.details.end_date.substring(0, 10));
                    $('input[name="start_date"]').val(data.details.start_date.substring(0, 10));
                    $('input[name="prefunded_amount"]').val(data.details.prefunded_amount);
                    $('input[name="margin"]').val(data.details.margin);
                    $('input[name="quantity"]').val(data.details.quantity);
                    $('select[name="partner"]').val(data.details.partner_id);
                    $('select[name="type"]').val(data.details.type);

                }, 'json');
            });

            $("#update_trade_form").on('submit', function(e) {
                e.preventDefault();
                $("#btnUpdate").css('display', 'none');
                $("#loadingUpdate").css('display', 'inline');
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {

                        if (data.status == 1) {
                            $('#trade-table').DataTable().ajax.reload(null, false);
                            $('#update_trade_form')[0].reset();
                            $('#edit-trade-modal').modal('hide');
                            toastr.success(data.msg);
                        } else if (data.status == 0) {

                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {

                            $('span.error_message').text(data.msg);
                        }
                        $("#loadingUpdate").css('display', 'none');
                        $("#btnUpdate").css('display', 'inline');
                    }
                });
            });



        });
    </script>
@endsection
