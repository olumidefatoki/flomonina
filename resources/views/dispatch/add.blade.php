<tr>
    <div id="add-dispatch-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add Truck dispatch</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{ route('dispatch.store') }}" id="create_dispatch_form">
                        @csrf
                        <div class="form pt-s">
                            <div class="form-group row">
                                <span style="font-size: 12px;" class="text-danger error-text error_message "></span>
                                <label class="col-5 col-form-label">Trade</label>
                                <div class="col-7">
                                    <select id="formGender" name="trade" class="form-control select">
                                        <option selected disabled>Select a Trade</option>
                                        @foreach ($trades as $trade)
                                        <option value="{{ $trade->id }}">
                                            {{ strtoupper($trade->partner->name) }} >>
                                            {{ strtoupper($trade->description) }} 
                                        </option>
                                        @endforeach
                                    </select>
                                    <span style="font-size: 12px;" class="text-danger error-text trade_error "></span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Aggregator</label>
                                <div class="col-7">
                                    <select id="formGender" name="aggregator" class="form-control select">
                                        <option selected disabled>Select a Aggregator</option>
                                        @foreach ($aggregators as $aggregator)
                                        <option value="{{ $aggregator->id }}">
                                            {{ $aggregator->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span style="font-size: 12px;" class="text-danger error-text aggregator_error "></span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Commodity</label>
                                <div class="col-7">
                                    <select id="formGender" name="commodity" class="form-control select">
                                        <option selected disabled>Select a Commodity</option>
                                        @foreach ($commodities as $commodity)
                                        <option value="{{ $commodity->id }}">
                                            {{ $commodity->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span style="font-size: 12px;" class="text-danger error-text commodity_error "></span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Number of bags</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="number_of_bags" placeholder="Number of bags">
                                    <span style="font-size: 12px;" class="text-danger error-text number_of_bags_error"></span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">PickUp Location</label>
                                <div class="col-7">
                                    <select id="formGender" name="pickup_state" class="form-control select">
                                        <option selected disabled>Select a State</option>
                                        @foreach ($states as $state)
                                        <option value="{{ $state->id }}">
                                            {{ $state->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span style="font-size: 12px;" class="text-danger error-text pickup_state_error "></span>

                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Destination</label>
                                <div class="col-7">
                                    <select id="formGender" name="destination_state" class="form-control select">
                                        <option selected disabled>Select a State</option>
                                        @foreach ($states as $state)
                                        <option value="{{ $state->id }}">
                                            {{ $state->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <span style="font-size: 12px;" class="text-danger error-text destination_state_error "></span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Logistics Company</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="logistics_company" placeholder="logistics_company">
                                    <span style="font-size: 12px;" class="text-danger error-text logistics_company_error"></span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Truck Number</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="truck_number" placeholder="Truck Number">
                                    <span style="font-size: 12px;" class="text-danger error-text truck_number_error"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-5 col-form-label">Driver Name</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="driver_name" placeholder="Driver Name">
                                    <span style="font-size: 12px;" class="text-danger error-text driver_name_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Driver Phone Number</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="driver_phone_number" placeholder="Driver Phone Number">
                                    <span style="font-size: 12px;" class="text-danger error-text driver_phone_number_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Expected Arrival Time</label>
                                <div class="col-7">
                                    <input type="text" name="estimated_arrival_time" class="form-control" placeholder="Estimated Arrival Time" id="eta_date">
                                    <span style="font-size: 12px;" class="text-danger error-text estimated_arrival_time_error"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-5 col-form-label">Dispatch Time</label>
                                <div class="col-7">
                                    <input type="text" name="dispatch_time" class="form-control" placeholder="dispatch_time" id="date">
                                    <span style="font-size: 12px;" class="text-danger error-text dispatch_time_error"></span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" name="date" class="form-control" placeholder="Date" id="date">
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text date_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success mr-2" id="btnSubmit">Create</button>
                            <div id="loading" style="display:none"> <img src="{{ URL::to('assets/images/ajax-loader.gif') }}" alt="" /></div>
                            <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</tr>