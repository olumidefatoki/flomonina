@extends('layouts.master')
@section('title')
Flomuvina | Delivery
@endsection
@section('link')
<link href="{{ URL::to('assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Deliverys</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Delivery</li>
                </ol>

            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <h3 class="box-title">Delivery Details</h3>
                            <hr class="m-t-0 m-b-40">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6">Partner:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                {{ $delivery->dispatch->trade->partner->name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6">Aggregator:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static"> {{ $delivery->dispatch->aggregator->name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6">Processor:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                {{ $delivery->dispatch->trade->food_processor }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6">Delivery Location:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static"> {{ $delivery->dispatch->trade->delivery_location }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6">Accepted Quantity:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                {{ number_format($delivery->accepted_quantity, 2) }} kg
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6">No of bags rejected:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">
                                                {{ number_format($delivery->no_of_bags_rejected) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6">Trade Price:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">&#8358; {{number_format($delivery->trade_price) }} </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6">Aggregator Price:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">&#8358; {{ number_format($delivery->aggregator_price) }} </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6"> Margin:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">&#8358; {{ $delivery->margin }} </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6">Agregator Amount:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static"> &#8358;
                                                {{ number_format($delivery->aggregator_price * $delivery->accepted_quantity) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6">Trade Amount:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static"> &#8358;
                                                {{ number_format($delivery->trade_price * $delivery->accepted_quantity) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6">Revenue:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static"> &#8358;
                                                {{ number_format($delivery->margin * $delivery->accepted_quantity) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6">Status:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static"> {{ $delivery->status->name }} </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->

                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-6">Way tickets:</label>
                                        <div class="col-md-6">
                                            <a class="image-popup-vertical-fit" href="{{asset( $delivery->way_ticket )}}" title="Way Ticket.">
                                                <img src="{{asset( $delivery->way_ticket )}}" alt="image" class="img-responsive" />
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="offset-sm-5 col-sm-9">
                                            <!-- <button type="submit" class="btn btn-success "> <i
                                                        class="fa fa-pencil"></i> Approve</button> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"> </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

</div>
@endsection

@section('script')
<script src="{{ URL::to('assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ URL::to('assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js') }}"></script>
@endsection