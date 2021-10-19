@extends('layouts.master')
@section('title')
Flomuvina | Partner
@endsection
@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">partners</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">partners</li>
                </ol>
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal" id="addpartnerBtn">
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
                    <div class="table-responsive">
                        <table id="partners-table" class="table m-t-30 table-hover no-wrap contact-list" data-paging="true" data-paging-size="7">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Address</th>
                                    <th>Contact Person</th>
                                    <th>Contact Email</th>
                                    <th>Contact Phone Number</th>
                                    <th>State Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            @include('partner.add')
                            @include('partner.edit')
                            <tfoot>
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
        $("#create_partner_form").on('submit', function(e) {
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
                    } else {
                        $('#partners-table').DataTable().ajax.reload(null, false);
                        $('#create_partner_form')[0].reset();
                        $('#add-partner-modal').modal('hide');
                    }
                }
            });
        });

        var table = $('#partners-table').DataTable({
            processing: true,
            serverSide: true,
            info: true,
            ajax: "{{ route('partner.list') }}",
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
                    name: 'name'
                },
                {
                    data: 'type',
                    name: 'type',
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
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $(document).on('click', '#addpartnerBtn', function() {
            $('#create_partner_form')[0].reset();
            $('#add-partner-modal').modal('show');
        });

        $(document).on('click', '#editPartnerBtn', function() {
            var id = $(this).data('id');
            $('#update_partner_form')[0].reset();
            $(document).find('span.error-text').text('');
            $('#edit-partner-modal').modal('show');

            $.get("{{ url('/partner/edit/') }}" + '/' + id, function(data) {
                //alert(data.details.name);
                $('input[name="id"]').val(data.details.id);
                $('input[name="name"]').val(data.details.name);
                $('input[name="address"]').val(data.details.address);
                $('input[name="contact_person_first_name"]').val(data.details
                    .contact_person_first_name);
                $('input[name="contact_person_last_name"]').val(data.details
                    .contact_person_last_name);
                $('input[name="contact_person_email"]').val(data.details.contact_person_email);
                $('input[name="contact_person_phone_number"]').val(data.details
                    .contact_person_phone_number);
                $('select[name="state"]').val(data.details.state_id);
                $('select[name="type"]').val(data.details.type);

            }, 'json');
        });

        $("#update_partner_form").on('submit', function(e) {
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
                        $('#partners-table').DataTable().ajax.reload(null, false);
                        $('#update_partner_form')[0].reset();
                        $('#edit-partner-modal').modal('hide');
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