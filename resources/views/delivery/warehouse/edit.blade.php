<tr>
    <div id="edit-warehouse-delivery-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit Warehouse  ticket</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{ route('delivery.warehouse.update') }}" id="update_warehouse_delivery_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id">
                        <span class=" col-md-12 m-b-20 text-danger error-text error_message"></span>
                        <div class="form pt-s">
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
                                    <span style="font-size: 10px;"
                                        class="text-danger error-text aggregator_error"></span>
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
                                    <span style="font-size: 10px;"
                                        class="text-danger error-text commodity_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Partner Price</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="partner_price"
                                        placeholder="Processor Price">
                                    <span style="font-size: 10px;"
                                        class="text-danger error-text partner_price_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Aggregator Price</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="aggregator_price"
                                        placeholder="Aggregator Price">
                                    <span style="font-size: 10px;"
                                        class="text-danger error-text aggregator_price_error"></span>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-5 col-form-label">Quantity</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="quantity" placeholder="Quantity">
                                    <span style="font-size: 10px;" class="text-danger error-text quantity_error"></span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Number of Bags</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="number_of_bags"
                                        placeholder="Number of Bags">
                                    <span style="font-size: 10px;"
                                        class="text-danger error-text number_of_bags_error"></span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Truck Number</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="truck_number"
                                        placeholder="Truck Number">
                                    <span style="font-size: 10px;"
                                        class="text-danger error-text truck_number_error"></span>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-5 col-form-label">Way Ticket</label>
                                <div class="col-7">
                                    <input type="file" id="input-file-now" name="way_ticket" class="dropify" />
                                    <span style="font-size: 10px;"
                                        class="text-danger error-text way_ticket_error"></span>
                                    <div class="img-holder"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-5 col-form-label">Date</label>
                                <div class="col-7">
                                    <input type="text" name="date" class="form-control" placeholder="Date" id="date">
                                    <span style="font-size: 10px;" class="text-danger error-text date_error"></span>

                                </div>
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