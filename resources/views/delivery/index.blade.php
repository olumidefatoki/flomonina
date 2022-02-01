@extends('layouts.master')
@section('title')
    Flomuvina | Delivery
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
                <h4 class="text-themecolor">Deliverys</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Delivery</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal"
                        id="addDeliveryBtn">
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
                            <div class="col-1">
                                <input type="text" class="form-control" name="code" id="code" placeholder="Code">
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control" name="truck_number" id="truck_number"
                                    placeholder="Truck Number">
                            </div>
                            <div class="col-md-2">
                                <select id="processor" name="processor" class="form-control select">
                                    <option selected disabled>Select a Processor</option>
                                    @foreach ($processors as $processor)
                                        <option value="{{ $processor->id }}">
                                            {{ strtoupper($processor->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <input type="text" name="start_date" class="form-control" placeholder="Start Date"
                                    id="start_date">
                            </div>
                            <div class="col-2">
                                <input type="text" name="end_date" class="form-control" placeholder="Start Date"
                                    id="end_date">
                            </div>
                            <div class="col-3">
                                <button class="btn btn-bg btn-success" id="btnFiterSubmitSearch"><i
                                        class="fa fa-filter"></i>
                                    Filter Search</button>
                                <a href="{{ route('delivery.index') }}">
                                    <button class="btn btn-bg btn-success" id="searchfilter"><i class="fa fa-filter"></i>
                                        Clear Filter</button>
                                </a>
                            </div>
                        </div>
                        <div class="form-group row">

                        </div>
                        <div class="table-responsive">
                            <table id="delivery-table" class="table m-t-30 table-hover no-wrap contact-list"
                                data-paging="true" data-paging-size="7">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Partner</th>
                                        <th>Aggregator</th>
                                        <th>Processor</th>
                                        <th>Code</th>
                                        <th>Commodity</th>
                                        <th>Truck No</th>
                                        <th nowrap>Accepted Quantity(kg)</th>
                                        <th nowrap>Discounted Amount(&#8358;)</th>
                                        <th nowrap>Aggregator Amount(&#8358;)</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    @include('delivery.add')
                                    @include('delivery.edit')
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
        $('#start_date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false
        });
        $('#end_date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false
        });
        $(function() {
                    $("#create_delivery_form").on('submit', function(e) {
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
                                            $('#delivery-table').DataTable().ajax.reload(null, false);
                                            $('#create_delivery_form')[0].reset();
                                            $('#add-delivery-modal').modal('hide');
                                        }
                                            else {
                                                $('span.error_message').text(data.msg);
                                            }
                                        }
                                    });
                            });

                        $(document).on('click', '#addDeliveryBtn', function() {
                            $('#create_delivery_form')[0].reset();
                            $('#add-delivery-modal').modal('show');
                        });

                        $(document).on('click', '#editDeliveryBtn', function() {
                            $('#update_delivery_form')[0].reset();
                            $('#edit-delivery-modal').modal('show');
                            var id = $(this).data('id');
                            $.get("{{ url('/delivery/edit/') }}" + '/' + id, function(data) {
                                console.log(data.details);
                                $('input[name="id"]').val(data.details.id);
                                $('input[name="discounted_price"]').val(data.details.discounted_price);
                                $('input[name="processor_price"]').val(data.details.trade_price);
                                $('input[name="partner_price"]').val(data.details.partner_price);
                                $('input[name="aggregator_price"]').val(data.details.aggregator_price);
                                $('input[name="accepted_quantity"]').val(data.details.accepted_quantity);
                                $('select[name="dispatch"]').val(data.details.dispatch_id);
                                $('select[name="processor"]').val(data.details.partner_id);

                            }, 'json');
                        });

                        $("#update_delivery_form").on('submit', function(e) {
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


                        var table = $('#delivery-table').DataTable({
                            processing: true,
                            serverSide: true,
                            info: true,
                            ajax: {
                                url: "{{ route('delivery.list') }}",
                                type: 'GET',
                                data: function(d) {
                                    d.code = $('#code').val();
                                    d.truck_number = $('#truck_number').val();
                                    d.partner_id = $('#processor').val();
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
                                    data: 'processor',
                                    name: 'processor',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'code',
                                    name: 'code ',
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
                                    data: 'truck_number',
                                    name: 'truck_number',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'accepted_quantity',
                                    name: 'accepted_quantity',
                                    orderable: false,
                                    searchable: false
                                },

                                {
                                    data: 'discounted_amount',
                                    name: 'discounted_amount',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'aggregator_amount',
                                    name: 'aggregator_amount',
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
                        }); $('#btnFiterSubmitSearch').click(function() {
                            $('#delivery-table').DataTable().draw(true);
                        });

                    });
    </script>
@endsection
