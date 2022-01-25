<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDeliveryRequest;
use App\Http\Requests\CreateWarehouseDeliveryRequest;
use App\Http\Requests\CreateWarehouseRequest;
use Exception;
use Validator;
use App\Models\Partner;
use App\Models\Aggregator;
use App\Models\Commodity;
use App\Models\Delivery;
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delivery $delivery)
    {
        $validator = Validator::make($request->all(), [
            'dispatch' => 'required|numeric',
            'processor' => 'required|numeric',
            'accepted_quantity' => ['required', new DecimalValidator()],
            'no_of_bags_rejected' => 'required|numeric',
            'aggregator_price' => ['required', new DecimalValidator()],
            'discounted_price' => ['required', new DecimalValidator()],
            'processor_price' => ['required', new DecimalValidator()],
            'way_ticket' => 'required|image|mimes:jpeg,png,jpg,gif|max:1048',
        ]);


        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }

        $orderPrice = Dispatch::join('buyer_order', 'buyer_order_id', '=', 'buyer_order.id')
            ->where('dispatch.id', '=', $request->dispatch)
            ->get(['buyer_order.price'])
            ->first();

        if ($request->partner_price > $orderPrice->price) {
            return response()->json(['status' => 0, 'error' => array('partner_price' => array('The Partner Price is greater than the Order Price. '))]);
        }
        $path = 'tickets/';
        $file = $request->file('way_ticket');
        $file_name = date('YmdHis') . '_' . $file->getClientOriginalName();

        $upload = $file->storeAs($path, $file_name, 'public');

        if ($upload) {
            $data = array(
                'dispatch_id' => $request->dispatch,
                'accepted_quantity' => $request->accepted_quantity,
                'aggregator_price' => $request->aggregator_price,
                'discounted_price' => $request->discounted_price,
                'trade_price' => $request->processor_price,
                'processor' => Partner::find($request->processor)->name,
                'partner_id' => $request->processor,
                'way_ticket' => $upload,
                'margin' => $request->processor_price - $request->aggregator_price,
                'status_id' => 8,
                'updated_by' => Auth::id(),
            );

            try {
                DB::enableQueryLog();
                $result = DB::table('delivery')->where('id', $request->id)->update($data);
                //dd(DB::getQueryLog());
                return response()->json(['status' => 1, 'msg' => ' Delivery has been successfully updated.']);
            } catch (Exception $ex) {
                Log::error($ex->getMessage());
                return response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']);
            }
        }
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
