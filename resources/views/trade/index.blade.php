@extends('layouts.master')
@section('title')
Flomuvina | Trade
@endsection
@section('link')
<link href="{{ URL::to('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Trade</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Trade</li>
                </ol>
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal" id="addTradeBtn">
                    <i class="fa fa-plus-circle"></i> Create New Trade</button>
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
                        <table id="trade-table" class="table m-t-30 table-hover no-wrap contact-list" data-paging="true" data-paging-size="7">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Partner</th>
                                    <th>Processor</th>
                                    <th>Address</th>
                                    <th>commodity</th>
                                    <th>price(&#8358;)</th>
                                    <th>Qty(MT)</th>
                                    <th>State Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot></tfoot>
                            @include('trade.add')
                            @include('trade.edit')

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
<script src="{{ URL::to('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
</script>

<script>
    $('#start_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false
    });
    $('#end_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false
    });
    $('#edit_start_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false
    });
    $('#edit_end_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false
    });
    $('#date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false
    });
    $(function() {
        $("#create_trade_form").on('submit', function(e) {
            e.preventDefault();
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
                    console.log(data);
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $('#trade-table').DataTable().ajax.reload(null, false);
                        $('#create_trade_form')[0].reset();
                        $('#add-trade-modal').modal('hide');
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
                $('input[name="address"]').val(data.details.delivery_location);
                $('input[name="price"]').val(data.details.price);
                $('input[name="quantity"]').val(data.details.quantity);
                $('select[name="commodity"]').val(data.details.commodity_id);
                $('select[name="partner"]').val(data.details.partner_id);
                $('select[name="processor"]').val(data.details.food_processor);
                $('select[name="state"]').val(data.details.state_id);

            }, 'json');
        });

        var table = $('#trade-table').DataTable({
            processing: true,
            serverSide: true,
            info: true,
            ajax: "{{ route('trade.list') }}",
            "pageLength": 50,
            "aLengthMenu": [
                [25, 50, -1],
                [25, 50, "All"]
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'partner',
                    name: 'partner'

                },
                {
                    data: 'food_processor',
                    name: 'food_processor'

                },

                {
                    data: 'delivery_location',
                    name: 'delivery_location',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'commodity_name',
                    name: 'commodity_name',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'price',
                    name: 'price',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'quantity',
                    name: 'quantity',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'state_name',
                    name: 'state_name',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'start_date',
                    name: 'start_date',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'end_date',
                    name: 'end_date',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_by',
                    name: 'created_by',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $("#update_trade_form").on('submit', function(e) {
            e.preventDefault();
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
                    console.log(data);
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
                }
            });
        });



    });
</script>
@endsection