@extends('layouts.master')
@section('title')
    Flomuvina | Warehouse
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
                <h4 class="text-themecolor">Warehouse</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Warehouse</li>
                        <li class="breadcrumb-item active">Flomovina</li>

                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal"
                        id="addwarehouseBtn">
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
                            <table id="warehouse-table" class="table m-t-30 table-hover no-wrap contact-list"
                                data-paging="true" data-paging-size="7">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Capacity</th>
                                        <th>State</th>
                                        <th>Lga</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot></tfoot>
                                @include('warehouse.flomuvina.add')

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

var table = $('#warehouse-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('warehouse.flomuvina.list') }}",
                    type: 'GET',
                    data: function(d) {
                        d.name = $('#name').val();
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
                        data: 'name',
                        name: 'name',
                         orderable: false,
                        searchable: false
                    },
                    {
                        data: 'address',
                        name: 'address',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'state',
                        name: 'state',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'lga',
                        name: 'lga',
                        orderable: false,
                        searchable: false

                    },
                   
                ]
            });

            $("#create_warehouse_form").on('submit', function(e) {
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
                            $('#warehouse-table').DataTable().ajax.reload(null, false);
                            $('#create_warehouse_form')[0].reset();
                            $('#add-warehouse-modal').modal('hide');
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

            $(document).on('click', '#addwarehouseBtn', function() {
                $('#create_warehouse_form')[0].reset();
                $('#add-warehouse-modal').modal('show');
            });
            $(document).on('click', '#editwarehouseBtn', function() {
                var id = $(this).data('id');
                $('#update_warehouse_form')[0].reset();
                $(document).find('span.error-text').text('');
                $('#edit-warehouse-modal').modal('show');
                $.get("{{ url('/warehouse/edit/') }}" + '/' + id, function(data) {
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

            $("#update_warehouse_form").on('submit', function(e) {
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
                            $('#warehouse-table').DataTable().ajax.reload(null, false);
                            $('#update_warehouse_form')[0].reset();
                            $('#edit-warehouse-modal').modal('hide');
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

            $('select[name="state"]').on('change', function() {
                $("#loadingLga").css("display", "inline-block");
                var stateId = $(this).val();
                $.ajax({
                    url: "{{ url('/lga/') }}" + '/' + stateId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="lga"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="lga"]').append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $("#loadingLga").css("display", "none");
                    }
                });
            });

        });
    </script>
@endsection
