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
                    <form class="form-horizontal" method="post" action="{{ route('inventory.supply.store') }}"
                        id="create_trade_form">
                        @csrf
                        <div class="form pt-3">
                            <span class="text-danger error-text error_message "></span>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Thrive Warehouse</label>
                                <div class="col-7">
                                    <select id="formGender" name="warehouse" class="form-control select">
                                        <option selected disabled>Select a warehouse</option>
                                         @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">
                                                {{ $warehouse->lga->state->name }} >>
                                                {{ $warehouse->lga->name }} >>
                                                {{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span style="font-size: 10px;"
                                        class="text-danger error-text warehouse_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Commodity</label>
                                <div class="col-7">
                                    <select id="trade_type" name="type" class="form-control select">
                                        <option selected disabled>Select a commodity</option>
                                        @foreach ($commodities as $commodity)
                                            <option value="{{ $commodity->id }}">
                                           {{ $commodity->name }}
                                            </option>
                                        @endforeach
                                    </select><span class="text-danger error-text type_error "></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Quantity</label>
                                <div class="col-7">
                                    <input type="text" name="start_date" class="form-control"
                                        placeholder="Warehouse Name">
                                    <span class="text-danger error-text start_date_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Average Weight</label>
                                <div class="col-7">
                                    <input type="text" name="start_date" class="form-control"
                                        placeholder="Warehouse Name">
                                    <span class="text-danger error-text start_date_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Unit Price</label>
                                <div class="col-7">
                                    <input type="text" name="start_date" class="form-control"
                                        placeholder="Warehouse Name">
                                    <span class="text-danger error-text start_date_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Amount</label>
                                <div class="col-7">
                                    <input type="text" name="start_date" class="form-control"
                                        placeholder="Warehouse Name">
                                    <span class="text-danger error-text start_date_error"></span>
                                </div>
                            </div>

                             <div class="form-group row">
                                <label class="col-5 col-form-label">Date</label>
                                <div class="col-7">
                                    <input type="text" name="date" class="form-control" placeholder="Date" id="date">
                                    <span style="font-size: 10px;" class="text-danger error-text date_error"></span>

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
