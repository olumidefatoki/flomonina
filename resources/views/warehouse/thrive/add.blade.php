<tr>
    <div id="add-warehouse-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add New Warehouse</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{ route('warehouse.thrive.store') }}"
                        id="create_warehouse_form">
                        @csrf
                        <div class="form pt-3">
                            <span class="text-danger error-text error_message "></span>

                            <div class="form-group row">
                                <label class="col-5 col-form-label">Name</label>
                                <div class="col-7">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Warehouse Name">
                                    <span class="text-danger error-text name_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Address</label>
                                <div class="col-7">
                                    <input type="text" name="address" class="form-control"
                                        placeholder="Warehouse Address">
                                    <span class="text-danger error-text address_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Description</label>
                                <div class="col-7">
                                    <input type="text" name="description" class="form-control"
                                        placeholder="Description">
                                    <span class="text-danger error-text description_error"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <span class="text-danger error-text"></span>
                                <label class="col-5 col-form-label">State</label>
                                <div class="col-7">
                                    <select id="formGender" name="state" class="form-control select">
                                       <option selected disabled>Select a state </option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select><span class="text-danger error-text state_error "></span>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Lga</label>
                                <div class="col-7">
                                    <select id="warehouse_type" name="lga" class="form-control select">
                                        <option selected disabled>Select a lga</option>

                                    </select><span class="text-danger error-text lga_error "></span>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success mr-2" id="btnSubmit">Create</button>
                                <div id="loading" style="display:none"> <img
                                        src="{{ URL::to('assets/images/ajax-loader.gif') }}" alt="" /></div>
                                <button type="button" class="btn btn-dark waves-effect"
                                    data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
</tr>
