<tr>
    <div id="add-trade-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add New Warehouse</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{ route('trade.store') }}"
                        id="create_trade_form">
                        @csrf
                        <div class="form pt-3">
                            <span class="text-danger error-text error_message "></span>
                            <div class="form-group row">
                                <span class="text-danger error-text"></span>
                                <label class="col-5 col-form-label">State</label>
                                <div class="col-7">
                                    <select id="formGender" name="partner" class="form-control select">
                                        <option selected disabled>Select a state </option>
                                    </select><span class="text-danger error-text partner_error "></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Lga</label>
                                <div class="col-7">
                                    <select id="trade_type" name="type" class="form-control select">
                                        <option selected disabled>Select a lga</option>
                                    </select><span class="text-danger error-text type_error "></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <span class="text-danger error-text"></span>
                                <label class="col-5 col-form-label">Market</label>
                                <div class="col-7">
                                    <select id="formGender" name="partner" class="form-control select">
                                        <option selected disabled>Select a market </option>
                                    </select><span class="text-danger error-text partner_error "></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Commodity</label>
                                <div class="col-7">
                                    <select id="trade_type" name="type" class="form-control select">
                                        <option selected disabled>Select a commodity</option>
                                    </select><span class="text-danger error-text type_error "></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Price</label>
                                <div class="col-7">
                                    <input type="text" name="start_date" class="form-control"
                                        placeholder="Warehouse Name">
                                    <span class="text-danger error-text start_date_error"></span>
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
