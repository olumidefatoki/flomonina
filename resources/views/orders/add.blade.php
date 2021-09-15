<tr>
    <div id="add-order-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add New Buyer Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{ route('order.store') }}"
                        id="create_order_form">
                        @csrf
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <select id="formGender" name="buyer" class="form-control select">
                                    <option selected disabled>Select a Buyer</option>
                                    @foreach ($buyers as $buyer)
                                        <option value="{{ $buyer->id }}">
                                            {{ $buyer->name }}</option>
                                    @endforeach
                                </select>
                                <span style="font-size: 10px;" class="text-danger error-text buyer_error "></span>
                            </div>

                            <div class="col-md-12 m-b-20">
                                <select id="formGender" name="commodity" class="form-control select">
                                    <option selected disabled>Select a Commodity</option>
                                    @foreach ($commodities as $commodity)
                                        <option value="{{ $commodity->id }}">
                                            {{ $commodity->name }}</option>
                                    @endforeach
                                </select>
                                <span style="font-size: 10px;" class="text-danger error-text commodity_error "></span>
                            </div>

                            <div class="col-md-12 m-b-20">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">&#8358;</span></div>
                                    <input type="text" class="form-control" name="price" placeholder="Price">
                                </div>
                                <span style="font-size: 10px;" class="text-danger error-text price_error"></span>

                            </div>
                            <div class="col-md-12 m-b-20">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">MT</span></div>
                                    <input type="text" class="form-control" name="quantity" placeholder="Quantity">
                                </div>
                                <span style="font-size: 10px;" class="text-danger error-text quantity_error"></span>

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
                                <input type="text" class="form-control" name="address" placeholder="Delivery Address">
                                <span style="font-size: 10px;" class="text-danger error-text address_error"></span>
                            </div>

                            <div class="col-md-12 m-b-20">
                                <input type="text" name="start_date" class="form-control" placeholder="Start Date"
                                    id="start_date">
                                <span style="font-size: 10px;" class="text-danger error-text start_date_error"></span>
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" name="end_date" class="form-control" placeholder="End Date"
                                    id="end_date">
                                <span style="font-size: 10px;" class="text-danger error-text end_date_error"></span>
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
