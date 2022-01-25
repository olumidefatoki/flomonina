@extends('layouts.master')
@section('title')
    Flomuvina | Delivery
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
                <h4 class="text-themecolor">Deliverys</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Delivery</li>
                        <li class="breadcrumb-item active">Warehouse</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal"
                        id="addWarehouseDeliveryBtn">
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
                            <div class="col-3">
                                <input type="text" class="form-control" name="code" id="code" placeholder="Code">
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" name="truck_number" id="truck_number"
                                    placeholder="Truck Number">
                            </div>
                            <div class="col-md-3">
                                <select id="commodity" name="commodity" class="form-control select">
                                    <option selected disabled>Select a Commodity</option>
                                    @foreach ($commodities as $commodity)
                                        <option value="{{ $commodity->id }}">
                                            {{ $commodity->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="aggregator" name="aggregator" class="form-control select">
                                    <option selected disabled>Select a Aggregator</option>
                                    @foreach ($aggregators as $aggregator)
                                        <option value="{{ $aggregator->id }}">
                                            {{ $aggregator->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-3">
                                <input type="text" name="start-date" class="form-control" placeholder="Start Date"
                                    id="start_date">
                            </div>
                            <div class="col-3">
                                <input type="text" name="end-date" class="form-control" placeholder="End Date"
                                    id="end_date">
                            </div>
                            <div class="col-6">
                                <button class="btn btn-bg btn-success" id="btnFiterSubmitSearch"><i
                                        class="fa fa-filter"></i>
                                    Filter Search</button>

                                <a href="{{ route('delivery.warehouse.index') }}">
                                    <button class="btn btn-bg btn-success" id="searchfilter"><i class="fa fa-filter"></i>
                                        Clear Filter</button>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="delivery-warehouse-table" class="table m-t-30 table-hover no-wrap contact-list"
                                data-paging="true" data-paging-size="7">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Code</th>
                                        <th>State</th>
                                        <th>WareHouse</th>
                                        <th>Partner</th>
                                        <th>Aggregator</th>
                                        <th>Truck Number</th>
                                        <th>Commodity</th>
                                        <th nowrap>Quantity(kg)</th>
                                        <th nowrap>Partner Price</th>
                                        <th nowrap>Aggregator Price</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    @include('delivery.warehouse.add')
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
        $('#start_date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false
        });
        $('#end_date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false
        });
        $(function() {

            var table = $('#delivery-warehouse-table').DataTable({
                processing: true,
                serverSide: true,
                info: true,
                ajax: {
                    url: "{{ route('delivery.warehouse.list') }}",
                    type: 'GET',
                    data: function(d) {
                        d.code = $('#code').val();
                        d.truck_number = $('#truck_number').val();
                        d.aggregator_id = $('#aggregator').val();
                        d.commodity_id = $('#commodity').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
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
                        name: 'code',
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
                        data: 'warehouse',
                        name: 'warehouse',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'partner',
                        name: 'partner',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'aggregator',
                        name: 'aggregator',
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
                        data: 'commodity',
                        name: 'commodity',
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
                        data: 'partner_price',
                        name: 'partner_price',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'aggregator_price',
                        name: 'aggregator_price',
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

            $("#create_delivery_warehouse_form").on('submit', function(e) {
                e.preventDefault();
                $("#btnSubmit").css('display', 'none');
                $("#loadingSubmit").css('display', 'inline');
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
                        $("#loadingSubmit").css('display', 'none');
                        $("#btnSubmit").css('display', 'inline');
                        if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (data.status == 1) {
                            $('#delivery-warehouse-table').DataTable().ajax.reload(null, false);
                            $('#create_delivery_warehouse_form')[0].reset();
                            $('#add-delivery-warehouse-modal').modal('hide');
                        } else {
                            $('span.error_message').text(data.msg);
                        }
                    }
                });
            });

            $(document).on('click', '#addWarehouseDeliveryBtn', function() {
                $('#create_delivery_warehouse_form')[0].reset();
                $('#add-delivery-warehouse-modal').modal('show');
            });

            $("#update_delivery_warehouse_form").on('submit', function(e) {
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
                            $('#delivery-table').DataTable().ajax.reload(null, false);
                            $('#update_delivery_form')[0].reset();
                            $('#edit-delivery-modal').modal('hide');
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
                $('#delivery-warehouse-table').DataTable().draw(true);
            });

            //Reset input file
            $('input[type="file"][name="way_ticket"]').val('');
            //Image preview
            $('input[type="file"][name="way_ticket"]').on('change', function() {
                var img_path = $(this)[0].value;
                var img_holder = $('.img-holder');
                var extension = img_path.substring(img_path.lastIndexOf('.') + 1).toLowerCase();

                if (extension == 'jpeg' || extension == 'jpg' || extension == 'png') {
                    if (typeof(FileReader) != 'undefined') {
                        img_holder.empty();
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('<img/>', {
                                'src': e.target.result,
                                'class': 'img-fluid',
                                'style': 'max-width:100px;margin-bottom:10px;'
                            }).appendTo(img_holder);
                        }
                        img_holder.show();
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        $(img_holder).html('This browser does not support FileReader');
                    }
                } else {
                    $(img_holder).empty();
                }
            });


        });
    </script>
@endsection
