<tr>
    <div id="add-dispatch-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add Truck dispatch</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{ route('dispatch.store') }}"
                        id="create_dispatch_form">
                        @csrf
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <select id="formGender" name="order" class="form-control select">
                                    <option selected disabled>Select a Order</option>
                                    @foreach ($buyerOrders as $order)
                                        <option value="{{ $order->id }}">
                                            {{ strtoupper($order->buyer->name) }} >>
                                            {{ $order->state->name }} >>
                                            {{ strtoupper($order->commodity->name) }} >>
                                        </option>
                                    @endforeach
                                </select>
                                <span style="font-size: 10px;" class="text-danger error-text order_error "></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <select id="formGender" name="partner" class="form-control select">
                                    <option selected disabled>Select a Partner</option>
                                    @foreach ($partners as $partner)
                                        <option value="{{ $partner->id }}">
                                            {{ $partner->name }}</option>
                                    @endforeach
                                </select>
                                <span style="font-size: 10px;" class="text-danger error-text partner_error "></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="driver_name" placeholder="Driver Name">
                                <span style="font-size: 10px;" class="text-danger error-text driver_name_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="driver_phone_number"
                                    placeholder="Driver Phone Number">
                                <span style="font-size: 10px;" class="text-danger error-text driver_phone_number_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="truck_number" placeholder="Truck Number">
                                <span style="font-size: 10px;" class="text-danger error-text truck_number_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="number_of_bags" placeholder="Number of bags">
                                <span style="font-size: 10px;" class="text-danger error-text number_of_bags_error"></span>
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
                                <input type="text" class="form-control" name="dispatch_location"
                                    placeholder="Dispatch Location of bags">
                                <span style="font-size: 10px;" class="text-danger error-text dispatch_location_error"></span>
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
