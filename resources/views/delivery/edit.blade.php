<tr>
    <div id="edit-delivery-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit Way ticket</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{ route('delivery-update') }}"
                        id="update_delivery_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id">
                        <span class=" col-md-12 m-b-20 text-danger error-text error_message"></span>
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <select id="formGender" name="dispatch" class="form-control select">
                                    <option selected disabled>Select a Truck number</option>
                                    @foreach ($dispatchs as $dispatch)
                                        <option value="{{ $dispatch->id }}">
                                            {{ strtoupper( $dispatch->truck_number) }}</option>
                                    @endforeach
                                </select>
                                <div id="loading" style="display:none"> <img src="{{ URL::to('assets/images/ajax-loader.gif') }}" alt="" /> Loading </div>
                                <span style="font-size: 10px;" class="text-danger error-text dispatch_error "></span>

                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="buyer" valued=""  placeholder="buyer" disabled>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="delivery" valued="" placeholder="delivery" disabled>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="commodity" valued="" placeholder="commodity" disabled>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="partner_price"
                                    placeholder="Partner Price">
                                <span style="font-size: 10px;"
                                    class="text-danger error-text partner_price_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="discounted_price"
                                    placeholder="Discounted Price">
                                <span style="font-size: 10px;"
                                    class="text-danger error-text discounted_price_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="accepted_quantity"
                                    placeholder="Quantity Accepted">
                                <span style="font-size: 10px;"
                                    class="text-danger error-text accepted_quantity_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="no_of_bags_rejected"
                                    placeholder="No of Bags Rejected">
                                <span style="font-size: 10px;"
                                    class="text-danger error-text no_of_bags_rejected_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="file" id="input-file-now" name="way_ticket" class="dropify" />
                                <span style="font-size: 10px;"
                                    class="text-danger error-text way_ticket_error"></span>
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
