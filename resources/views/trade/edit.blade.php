<tr>
    <div id="edit-trade-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit Buyer Trade</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{ route('trade-update') }}" id="update_trade_form">
                        @csrf
                        <input type="hidden" name="id">
                        <span class=" col-md-12 m-b-20 text-danger error-text error_message"></span>
                        <div class="form pt-3">
                            <div class="form-group">
                                <label>Partner</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <select id="formGender" name="partner" class="form-control select">
                                            <option selected disabled>Select a Partner</option>
                                            @foreach ($partners as $partner)
                                            <option value="{{ $partner->id }}">
                                                {{ $partner->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text partner_error "></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Processor</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <select id="formGender" name="processor" class="form-control select">
                                            <option selected disabled>Select a Processor</option>
                                            @foreach ($processors as $processor)
                                            <option value="{{ $processor->name }}">
                                                {{ $processor->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text processor_error "></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Commodity</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <select id="formGender" name="commodity" class="form-control select">
                                            <option selected disabled>Select a Commodity</option>
                                            @foreach ($commodities as $commodity)
                                            <option value="{{ $commodity->id }}">
                                                {{ $commodity->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text commodity_error "></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">&#8358;</span></div>
                                        <input type="text" class="form-control" name="price" placeholder="Price">
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text price_error"></span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">MT</span></div>
                                        <input type="text" class="form-control" name="quantity" placeholder="Quantity">
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text quantity_error"></span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label>State</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <select id="formGender" name="state" class="form-control select">
                                            <option selected disabled>Select a State</option>
                                            @foreach ($states as $state)
                                            <option value="{{ $state->id }}">
                                                {{ $state->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text state_error "></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="address" placeholder="Delivery Address">
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text address_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" name="start_date" class="form-control" placeholder="Start Date" id="start_date">
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text start_date_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" name="end_date" class="form-control" placeholder="End Date" id="end_date">
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text end_date_error"></span>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success mr-2">Update</button>
                            <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
</tr>