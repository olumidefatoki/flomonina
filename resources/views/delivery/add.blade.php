<tr>
    <div id="add-delivery-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Upload New Way ticket</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{ route('delivery.store') }}"
                        id="create_delivery_form" enctype="multipart/form-data">
                        @csrf
                        <div class="form pt-s">
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Truck number</label>
                                <div class="col-7">
                                    <select id="formGender" name="dispatch" class="form-control select">
                                        <option selected disabled>Select a Truck number</option>
                                        @foreach ($dispatchs as $dispatch)
                                            <option value="{{ $dispatch->id }}">
                                                {{ strtoupper($dispatch->code) }} >>
                                                {{ strtoupper($dispatch->truck_number) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span style="font-size: 10px;"
                                        class="text-danger error-text dispatch_error "></span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Processor</label>
                                <div class="col-7">
                                    <select id="formGender" name="processor" class="form-control select">
                                        <option selected disabled>Select</option>
                                        @foreach ($processors as $processor)
                                            <option value="{{ $processor->id }}">
                                                {{ strtoupper($processor->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span style="font-size: 10px;"
                                        class="text-danger error-text processor_error "></span>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-5 col-form-label">Proccessor Price</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="processor_price"
                                        placeholder="Processor Price">
                                    <span style="font-size: 10px;"
                                        class="text-danger error-text processor_price_error"></span>

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
                                <label class="col-5 col-form-label">Discounted Price</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="discounted_price"
                                        placeholder="Discounted Price">
                                    <span style="font-size: 10px;"
                                        class="text-danger error-text discounted_price_error"></span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label">Quantity Accepted</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="accepted_quantity"
                                        placeholder="Quantity Accepted">
                                    <span style="font-size: 10px;"
                                        class="text-danger error-text accepted_quantity_error"></span>

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
                            <button type="submit" class="btn btn-success mr-2" id="btnSubmit">Create</button>
                            <div id="loadingSubmit" style="display:none"> <img
                                    src="{{ URL::to('assets/images/ajax-loader.gif') }}" alt="" /></div>
                            <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
</tr>
