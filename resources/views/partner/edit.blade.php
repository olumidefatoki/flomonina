<tr>
    <div id="edit-partner-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit partner</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{ route('partner-update') }}" id="update_partner_form">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="id">
                            <span class=" col-md-12 m-b-20 text-danger error-text error_message"></span>
                            <div class="col-md-12 m-b-20 @error('name') has-error has-feedback @enderror">
                                <input type="text" class="form-control" name="name" placeholder="Name" value="">
                                <span style="font-size: 10px;" class="text-danger modal-body-error error-text name_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <select id="formGender" name="type" class="form-control select">
                                    <option selected disabled>Select</option>
                                    <option value="financier">Financier</option>
                                    <option value="processor">Processor</option>

                                </select>
                                <span style="font-size: 10px;" class="text-danger error-text state_error "></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="address" placeholder="Address" value="">
                                <span style="font-size: 10px;" class="text-danger error-text address_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="contact_person_first_name" placeholder="Contact Person First Name" value="">
                                <span style="font-size: 10px;" class="text-danger error-text contact_person_first_name_error"></span>
                            </div>

                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="contact_person_last_name" value=""" placeholder=" Contact Person Last Name">
                            </div>
                            <div class="  col-md-12 m-b-20">
                                <input type="text" class="form-control" name="contact_person_email" placeholder="Contact Person Email" value="">
                                <span style="font-size: 10px;" class="text-danger error-text contact_person_email_error"></span>
                            </div>

                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="contact_person_phone_number" placeholder="Contact Person Phone Number" value="">
                                <span style="font-size: 10px;" class="text-danger error-text contact_person_phone_number_error"></span>
                            </div>

                            <div class="col-md-12 m-b-20">
                                <select id="formGender" name="state" class="form-control select">
                                    <option selected disabled>Partner State</option>
                                    @foreach ($states as $state)
                                    <option value="{{ $state->id }}">
                                        {{ $state->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <span style="font-size: 10px;" class="text-danger error-text state_error "></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success mr-2" id="btnUpdate">Update</button>
                            <div id="loadingUpdate" style="display:none"> <img src="{{ URL::to('assets/images/ajax-loader.gif') }}" alt="" /></div>
                            <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
</tr>