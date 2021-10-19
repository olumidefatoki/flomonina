<tr>
    <div id="add-trade-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add New Trade</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{ route('trade.store') }}" id="create_trade_form">
                        @csrf
                        <div class="form pt-3">
                            <span class="text-danger error-text error_message "></span>
                            <div class="form-group row">
                                <span class="text-danger error-text"></span>
                                <label class="col-5 col-form-label">Partner</label>
                                <div class="col-7">
                                    <select id="formGender" name="partner" class="form-control select">
                                        <option selected disabled>Select a Partner</option>
                                        @foreach ($partners as $partner)
                                        <option value="{{ $partner->id }}">
                                            {{ $partner->name }}
                                        </option>
                                        @endforeach
                                    </select><span class="text-danger error-text partner_error "></span>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Type</label>
                                <div class="col-7">
                                    <select id="trade_type" name="type" class="form-control select">
                                        <option selected disabled>Select</option>
                                        <option value="Prefunded">Prefunded</option>
                                        <option value="Direct sourcing">Direct sourcing</option>
                                    </select><span class="text-danger error-text type_error "></span>
                                </div>

                            </div>
                            <div class="form-group row" id="amount" style="display:none">
                                <label class="col-5 col-form-label">Prefunded Amount</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="prefunded_amount" placeholder="Amount">
                                </div>
                            </div>
                            <div class="form-group row" id="">
                                <label class="col-5 col-form-label">Margin(kg)</label>
                                <div class="col-7">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">&#8358;</span></div>
                                        <input type="text" class="form-control" name="margin" placeholder="Margin">
                                    </div><span class="text-danger error-text margin_error"></span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Quantity</label>
                                <div class="col-7">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">MT</span></div>
                                        <input type="text" class="form-control" name="quantity" placeholder="Quantity">
                                    </div>
                                    <span class="text-danger error-text quantity_error"></span>

                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Start Date</label>
                                <div class="col-7">
                                    <input type="text" name="start_date" class="form-control" placeholder="Start Date" id="start_date">
                                    <span class="text-danger error-text start_date_error"></span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">End Date</label>
                                <div class="col-7">
                                    <input type="text" name="end_date" class="form-control" placeholder="End Date" id="end_date">
                                    <span class="text-danger error-text end_date_error"></span>

                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-5 col-form-label">Date</label>
                                <div class="col-7">
                                    <input type="text" name="date" class="form-control" placeholder="Date" id="date">
                                </div>
                                <span class="text-danger error-text date_error"></span>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success mr-2" id="btnSubmit">Create</button>
                                <div id="loading" style="display:none"> <img src="{{ URL::to('assets/images/ajax-loader.gif') }}" alt="" /></div>
                                <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
</tr>