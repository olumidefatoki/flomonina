<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDeliveryRequest;
use App\Http\Requests\CreateWarehouseDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use Exception;
use Validator;
use App\Models\Partner;
use App\Models\Aggregator;
use App\Models\Commodity;
use App\Models\Delivery;
use App\Models\WarehouseDelivery;
use App\Models\Dispatch;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Rules\DecimalValidator;
use App\Services\DeliveryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dispatchs = Dispatch::where('status_id', 3)->get();
        return view(
            'delivery.index',
            [
                'dispatchs' => $dispatchs,
                'processors' => Partner::where('type', 'PROCESSOR')->get(),
            ]
        );
    }

    public function warehouseIndex()
    {
        return view(
            'delivery.warehouse.index',
            [
                'warehouses' => Warehouse::all(),
                'aggregators' => Aggregator::all(),
                'commodities' => Commodity::all(),
            ]
        );
    }

    public function getDeliveryList(Request $request, DeliveryService $service)
    {
        return $service->getAllDeliveries($request);
    }
    public function getWareHouseDeliveryList(Request $request, DeliveryService $service)
    {
        return $service->getAllWarehouseDeliveries($request);
    }

    public function getDeliveryDetails($id)
    {
        return view('delivery.view', ['delivery' => Delivery::find($id)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDeliveryRequest $request, DeliveryService $service)
    {
        if ($service->create($request)) {
            return response()->json(['status' => 1, 'msg' => 'Way Ticket has been successfully upload.']);
        }
        return response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']);
    }

    public function warehouseStore(CreateWarehouseDeliveryRequest $request, DeliveryService $service)
    {
        if ($service->warehouseCreate($request)) {
            return response()->json(['status' => 1, 'msg' => 'Way Ticket has been successfully upload.']);
        }
        return response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $deliveries = Delivery::find($id);
        return response()->json(['details' => $deliveries]);
    }

    public function editWareHouseDelivery($id)
    {
        $deliveries = WarehouseDelivery::find($id);
        return response()->json(['details' => $deliveries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeliveryRequest $request, DeliveryService $service)
    {

        if ($service->update($request)) {
            return response()->json(['status' => 1, 'msg' => 'Delivery has been successfully updated.']);
        }
        return response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']);
    }

    public function updateWarehouseDelivery(CreateWarehouseDeliveryRequest $request, DeliveryService $service)
    {
            $service->warehouseUpdate($request);
            return response()->json(['status' => 1, 'msg' => 'Delivery has been successfully updated.']);
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        //
    }
}
