<tr>
    <div id="add-partner-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add New
                        partner</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{ route('partner.store') }}"
                        id="create_partner_form">
                        @csrf
                        <div class="form-group">
                            <div class="col-md-12 m-b-20 @error('name') has-error has-feedback @enderror">
                                <input type="text" class="form-control" name="name" placeholder="Company Name">
                                <span style="font-size: 10px;"
                                    class="text-danger modal-body-error error-text name_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="address" placeholder="Address">
                                <span style="font-size: 10px;" class="text-danger error-text address_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="contact_person_name"
                                    placeholder="Contact Person  Name">
                                <span style="font-size: 10px;"
                                    class="text-danger error-text contact_person_name_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="contact_person_email"
                                    placeholder="Contact Person Email">
                                <span style="font-size: 10px;"
                                    class="text-danger error-text contact_person_email_error"></span>
                            </div>

                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="contact_person_phone_number"
                                    placeholder="Contact Person Phone Number">
                                <span style="font-size: 10px;"
                                    class="text-danger error-text contact_person_phone_number_error"></span>
                            </div>

                            <div class="col-md-12 m-b-20">
                                <select id="formGender" name="state" class="form-control select">
                                    <option selected disabled>Select a State</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}">
                                            {{ $state->name }}</option>
                                    @endforeach
                                </select>
                                <span style="font-size: 10px;" class="text-danger error-text state_error "></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <select id="formGender" name="bank" class="form-control select">
                                    <option selected disabled>Select a Bank</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">
                                            {{ $bank->name }}</option>
                                    @endforeach
                                </select>
                                <span style="font-size: 10px;" class="text-danger error-text bank_error "></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="account_name"
                                    placeholder="Account Name">
                                <span style="font-size: 10px;" class="text-danger error-text account_name_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="account_number"
                                    placeholder="Account Number">
                                <span style="font-size: 10px;"
                                    class="text-danger error-text account_number_error"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success mr-2">Create</button>
                            <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
</tr>
