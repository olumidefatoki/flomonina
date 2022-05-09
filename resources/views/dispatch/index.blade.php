@extends('layouts.master')
@section('title')
    Flomuvina | Dispatch
@endsection
@section('link')
    <link
        href="{{ URL::to('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
        rel="stylesheet">
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
                <h4 class="text-themecolor">Dispatchs</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dispatch</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal"
                        id="addDispatchBtn">
                        <i class="fa fa-plus-circle"></i> Create New</button>
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
                        <div class="form-group row">
                            <div class="col-2">
                                <input type="text" class="form-control" name="code" id="code" placeholder="Code">
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control" name="truck_number" id="truck_number"
                                    placeholder="Truck Number">
                            </div>
                            <div class="col-md-2">
                                <select id="commodity" name="commodity" class="form-control select">
                                    <option selected disabled>Select a Commodity</option>
                                    @foreach ($commodities as $commodity)
                                        <option value="{{ $commodity->id }}">
                                            {{ $commodity->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select id="aggregator" name="aggregator" class="form-control select">
                                    <option selected disabled>Select a Aggregator</option>
                                    @foreach ($aggregators as $aggregator)
                                        <option value="{{ $aggregator->id }}">
                                            {{ $aggregator->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select id="status" name="status" class="form-control select">
                                    <option selected disabled>Select a Status</option>
                                    @foreach ($status as $stat)
                                        <option value="{{ $stat->id }}">
                                            {{ $stat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-2">
                                <input type="text" name="start-date" class="form-control" placeholder="Start Date"
                                    id="start-date">
                            </div>
                            <div class="col-2">
                                <input type="text" name="end-date" class="form-control" placeholder="end Date"
                                    id="end-date">
                            </div>
                            <div class="col-6">
                                <button class="btn btn-bg btn-success" id="btnFiterSubmitSearch"><i
                                        class="fa fa-filter"></i>
                                    Filter Search</button>

                                <a href="{{ route('dispatch.index') }}">
                                    <button class="btn btn-bg btn-success" id="searchfilter"><i class="fa fa-filter"></i>
                                        Clear Filter</button>
                                </a>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table id="dispatch-table" class="table m-t-30 table-hover no-wrap contact-list"
                                data-paging="true" data-paging-size="7">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Code</th>
                                        <th>Partner</th>
                                        <th>Aggregator</th>
                                        <th>Commodity</th>
                                        <th>Number of bags</th>
                                        <th>Pickup State</th>
                                        <th>Destination State</th>
                                        <th>Logisitcs Company</th>
                                        <th>Truck No</th>
                                        <th>Driver Name</th>
                                        <th>Driver Phone Number</th>
                                        <th>Status</th>
                                        <th>Expected Arrivial Date</th>
                                        <th>Dispach Date</th>
                                        <th>Uploaded Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    @include('dispatch.add')
                                    @include('dispatch.edit')
                                </tfoot>
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
        $('#date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false
        });
        $('#eta_date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false
        });
        $('#dispatch_time').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false
        });
        $(function() {

            $("#create_dispatch_form").on('submit', function(e) {
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
                        if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (data.status == 1) {
                            $('#dispatch-table').DataTable().ajax.reload(null, false);
                            $('#create_dispatch_form')[0].reset();
                            $('#add-dispatch-modal').modal('hide');
                        } else {
                            $('span.error_message').text(data.msg);
                        }
                    }
                });
            });

            $(document).on('click', '#addDispatchBtn', function() {
                $('#create_dispatch_form')[0].reset();
                $('#add-dispatch-modal').modal('show');
            });

            $(document).on('click', '#editDispatchBtn', function() {
                var id = $(this).data('id');
                $('#update_dispatch_form')[0].reset();
                $(document).find('span.error-text').text('');
                $('#edit-dispatch-modal').modal('show');
                $.get("{{ url('/dispatch/edit/') }}" + '/' + id, function(data) {
                    console.log(data);
                    $('input[name="id"]').val(data.details.id);
                    $('input[name="estimated_arrival_time"]').val(data.details
                        .estimated_arrival_time.substring(0, 10));
                    $('input[name="driver_phone_number"]').val(data.details.driver_number);
                    $('input[name="driver_name"]').val(data.details.driver_name);
                    $('input[name="truck_number"]').val(data.details.truck_number);
                    $('select[name="trade"]').val(data.details.trade_id);
                    $('select[name="aggregator"]').val(data.details.aggregator_id);
                    $('select[name="destination_state"]').val(data.details.destination_state_id);
                    $('select[name="pickup_state"]').val(data.details.pickup_state_id);
                    $('select[name="commodity"]').val(data.details.commodity_id);
                    $('input[name="number_of_bags"]').val(data.details.number_of_bags);
                    $('input[name="logistics_company"]').val(data.details.logistics_company);
                    $('input[name="dispatch_time"]').val(data.details.dispatch_time.substring(0,
                        10));

                }, 'json');
            });

            var table = $('#dispatch-table').DataTable({
                processing: true,
                serverSide: true,
                info: true,
                ajax: {
                    url: "{{ route('dispatch.list') }}",
                    type: 'GET',
                    data: function(d) {
                        d.code = $('#code').val();
                        d.truck_number = $('#truck_number').val();
                        d.commodity_id = $('#commodity').val();
                        d.aggregator_id = $('#aggregator').val();
                        d.start_date = $('#start-date').val();
                        d.end_date = $('#end-date').val();
                        d.status_id = $('#status').val();
                    }
                },
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
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'partner',
                        name: 'partner'
                    },
                    {
                        data: 'aggregator',
                        name: 'aggregator'
                    },
                    {
                        data: 'commodity',
                        name: 'commodity',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'number_of_bags',
                        name: 'number_of_bags',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'pickupstate',
                        name: 'pickupstate',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'destState',
                        name: 'destState',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'logistics_company',
                        name: 'logistics_company',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'truck_number',
                        name: 'truck_number',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'driver_name',
                        name: 'driver_name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'driver_number',
                        name: 'driver_number',
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
                        data: 'estimated_arrival_time',
                        name: 'estimated_arrival_time',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'dispatch_time',
                        name: 'dispatch_time',
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

            $("#update_dispatch_form").on('submit', function(e) {
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
                        $("#loadingUpdate").css('display', 'none');
                        $("#btnUpdate").css('display', 'inline');
                        if (data.status == 1) {
                            $('#dispatch-table').DataTable().ajax.reload(null, false);
                            $('#update_dispatch_form')[0].reset();
                            $('#edit-dispatch-modal').modal('hide');
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

            $('#btnFiterSubmitSearch').click(function() {
                $('#dispatch-table').DataTable().draw(true);
            });


        });
    </script>
@endsection
