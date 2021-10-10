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
                            <div class="form-group">
                                <label>Trade</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <select id="formGender" name="trade" class="form-control select">
                                            <option selected disabled>Select a Trade</option>
                                            @foreach ($trades as $trade)
                                            <option value="{{ $trade->id }}">
                                                {{ strtoupper($trade->partner->name) }} >>
                                                {{ $trade->state->name }} >>
                                                {{ strtoupper($trade->commodity->name) }} >>
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text trade_error "></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Aggregator</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <select id="formGender" name="aggregator" class="form-control select">
                                            <option selected disabled>Select a Aggregator</option>
                                            @foreach ($aggregators as $aggregator)
                                            <option value="{{ $aggregator->id }}">
                                                {{ $aggregator->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div> <span style="font-size: 10px;" class="text-danger error-text aggregator_error "></span>

                                </div>
                            </div>

                            <div class="form-group">
                                <label>Driver Name</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="driver_name" placeholder="Driver Name">
                                    </div> <span style="font-size: 10px;" class="text-danger error-text driver_name_error"></span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Driver Phone Number</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="driver_phone_number" placeholder="Driver Phone Number">
                                    </div> <span style="font-size: 10px;" class="text-danger error-text driver_phone_number_error"></span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Truck Number</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="truck_number" placeholder="Truck Number">
                                    </div> <span style="font-size: 10px;" class="text-danger error-text truck_number_error"></span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Number of bags</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="number_of_bags" placeholder="Number of bags">
                                    </div> <span style="font-size: 10px;" class="text-danger error-text number_of_bags_error"></span>

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
                                    </div> <span style="font-size: 10px;" class="text-danger error-text state_error "></span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pickup Location</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="pickup_location" placeholder="Pickup Location">
                                    </div> <span style="font-size: 10px;" class="text-danger error-text pickup_location_error"></span>

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
                            <button type="submit" class="btn btn-success mr-2">Create</button>
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