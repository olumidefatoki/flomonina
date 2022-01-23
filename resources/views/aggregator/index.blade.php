@extends('layouts.master')
@section('title')
    Flomuvina | Aggregator
@endsection
@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Aggregators</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Aggregators</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal"
                        id="addAggregatorBtn">
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
                            <div class="col-5">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                            </div>
                            <div class="col-3">
                                <button class="btn btn-sm btn-success" id="btnFiterSubmitSearch"><i
                                        class="fa fa-filter"></i>
                                    Filter Search</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="aggregators-table" class="table m-t-30 table-hover no-wrap contact-list"
                                data-paging="true" data-paging-size="7">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Contact Person</th>
                                        <th>Contact Email</th>
                                        <th no-wrap>Contact Phone Number</th>
                                        <th>State Name</th>
                                        <th>Bank Name</th>
                                        <th>Account Name</th>
                                        <th>Account Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    @include('aggregator.add')
                                    @include('aggregator.edit')
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
    <script>
        $(function() {
            $("#create_aggregator_form").on('submit', function(e) {
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
                            $('#aggregators-table').DataTable().ajax.reload(null, false);
                            $('#create_aggregator_form')[0].reset();
                            $('#add-aggregator-modal').modal('hide');
                        }
                    }
                });
            });

            var table = $('#aggregators-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('aggregator.list') }}",
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
                    },
                    {
                        data: 'address',
                        name: 'address',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'contact_person_name',
                        name: 'contact_person_name',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'contact_person_email',
                        name: 'contact_person_email',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'contact_person_phone_number',
                        name: 'contact_person_phone_number',
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
                        data: 'bank_name',
                        name: 'bank_name',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'account_name',
                        name: 'account_name',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'account_number',
                        name: 'account_number',
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

            $(document).on('click', '#addAggregatorBtn', function() {
                $('#create_aggregator_form')[0].reset();
                $('#add-aggregator-modal').modal('show');
            });

            $(document).on('click', '#editAggregatorBtn', function() {
                var id = $(this).data('id');
                $('#update_aggregator_form')[0].reset();
                $(document).find('span.error-text').text('');
                $('#edit-aggregator-modal').modal('show');

                $.get("{{ url('/aggregator/edit/') }}" + '/' + id, function(data) {
                    console.log(data.details);
                    $('input[name="id"]').val(data.details.id);
                    $('input[name="name"]').val(data.details.name);
                    $('input[name="address"]').val(data.details.address);
                    $('input[name="contact_person_first_name"]').val(data.details
                        .contact_person_first_name);
                    $('input[name="contact_person_name"]').val(data.details
                        .contact_person_name);
                    $('input[name="contact_person_email"]').val(data.details.contact_person_email);
                    $('input[name="contact_person_phone_number"]').val(data.details
                        .contact_person_phone_number);
                    $('select[name="state"]').val(data.details.state_id);
                    $('select[name="bank"]').val(data.details.bank_id);
                    $('input[name="account_number"]').val(data.details.account_number);
                    $('input[name="account_name"]').val(data.details.account_name);

                }, 'json');
            });

            $("#update_aggregator_form").on('submit', function(e) {
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
                        } else if (data.status == 1) {
                            $('#aggregators-table').DataTable().ajax.reload(null, false);
                            $('#update_aggregator_form')[0].reset();
                            $('#edit-aggregator-modal').modal('hide');
                            toastr.success(data.msg);
                        } else {
                            $('span.error_message').text(data.msg);
                        }
                    }
                });
            });

            $('#btnFiterSubmitSearch').click(function() {
                $('#aggregators-table').DataTable().draw(true);
            });

        });
    </script>
@endsection
