<tr>
    <div id="add-delivery-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Upload New Way ticket</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{ route('delivery.store') }}" id="create_delivery_form" enctype="multipart/form-data">
                        @csrf
                        <div class="form pt-s">
                            <div class="form-group">
                                <label>Truck number</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <select id="formGender" name="dispatch" class="form-control select">
                                            <option selected disabled>Select a Truck number</option>
                                            @foreach ($dispatchs as $dispatch)
                                            <option value="{{ $dispatch->id }}">
                                                {{ strtoupper( $dispatch->truck_number) }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div id="loading" style="display:none"> <img src="{{ URL::to('assets/images/ajax-loader.gif') }}" alt="" /> Loading </div>
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text dispatch_error "></span>
                                </div>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="partner" valued="" placeholder="Partner" disabled>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="aggregator" valued="" placeholder="Aggregator" disabled>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="commodity" valued="" placeholder="commodity" disabled>
                            </div>
                            <div class="form-group">
                                <label>Aggregator Price</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="aggregator_price" placeholder="Aggregator Price">
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text aggregator_price_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Discounted Price</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="discounted_price" placeholder="Discounted Price">
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text discounted_price_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Quantity Accepted</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="accepted_quantity" placeholder="Quantity Accepted">
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text accepted_quantity_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>No of Bags Rejected</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="no_of_bags_rejected" placeholder="No of Bags Rejected">
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text no_of_bags_rejected_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Way Ticket</label>
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="file" id="input-file-now" name="way_ticket" class="dropify" />
                                    </div>
                                    <span style="font-size: 10px;" class="text-danger error-text way_ticket_error"></span>
                                </div>
                            </div>

                            <div class="img-holder"></div>
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
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
</tr>