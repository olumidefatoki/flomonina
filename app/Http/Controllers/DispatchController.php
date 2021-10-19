<?php

namespace App\Http\Controllers;

use App\Models\Dispatch;
use App\Models\Delivery;
use App\Models\State;
use App\Models\Trade;
use App\Models\Aggregator;
use App\Models\Commodity;
use Validator;
use DataTables;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class DispatchController extends Controller
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
        $date = now();

        $trades = Trade::where('end_date', '>', $date)->get();
        return view('dispatch.index', [
            'trades' => $trades,
            'aggregators' => Aggregator::all(),
            'states' => State::all(),
            'commodities' => Commodity::all(),
        ]);
    }

    public function getDispatchList(Request $request)
    {
        // DB::enableQueryLog();
        $dispatchs = Dispatch::join('trade', 'trade.id', '=', 'dispatch.trade_id')
            ->join('partner', 'partner.id', '=', 'trade.partner_id')
            ->join('state as pickupState', 'pickupState.id', '=', 'dispatch.pickup_state_id')
            ->join('state as destState', 'destState.id', '=', 'dispatch.destination_state_id')
            ->join('status', 'status.id', '=', 'dispatch.status_id')
            ->join('aggregator', 'aggregator.id', '=', 'dispatch.aggregator_id')
            ->join('commodity', 'commodity.id', '=', 'dispatch.commodity_id')
            ->orderBy('dispatch.created_at', 'desc')
            ->get([
                'dispatch.*', 'partner.name As partner', 'pickupState.name As pickupstate', 'destState.name As destState',
                'status.name As status',
                'aggregator.name As aggregator', 'commodity.name As commodity'
            ]);
        //dd(DB::getQueryLog());

        return DataTables::of($dispatchs)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                                                <button class="btn btn-sm btn-info" data-id="' . $row['id'] . '" id="editDispatchBtn">Edit</button> 
                                          </div>';
            })->editColumn('created_at', function ($item) {
                if (empty($item->created_at))
                    return $item->created_at;
                return date('Y-m-d H:i:s', strtotime($item->created_at));
            })->editColumn('estimated_arrival_time', function ($item) {
                return date('Y-m-d', strtotime($item->estimated_arrival_time));
            })->editColumn('number_of_bags', function ($item) {
                return number_format($item->number_of_bags);
            })->rawColumns(['actions'])
            ->make(true);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trade' => 'required|numeric',
            'aggregator' => 'required|numeric',
            'number_of_bags' => 'required|numeric',
            'truck_number' => 'required|max:8',
            'driver_name' => 'required|max:255',
            'driver_phone_number' => 'required|digits:11',
            'pickup_state' => 'required|numeric',
            'destination_state' => 'required|numeric',
            'commodity' => 'required|numeric',
            'estimated_arrival_time' => 'required|date_format:Y-m-d',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }

        if (empty($request->dispatch_time)) {
            $request->dispatch_time = now();
        }
        $dataCount = Dispatch::where('truck_number', $request->truck_number)
            ->where('status_id', 3)
            ->count();
        if ($dataCount > 1) {
            return response()->json(['status' => 0, 'error' => array('truck_number' => array('truck number is already on Transit.'))]);
        }

        $data = array(
            'trade_id' => $request->trade,
            'aggregator_id' => $request->aggregator,
            'number_of_bags' => $request->number_of_bags,
            'truck_number' => $request->truck_number,
            'driver_name' => $request->driver_name,
            'driver_number' => $request->driver_phone_number,
            'pickup_state_id' => $request->pickup_state,
            'destination_state_id' => $request->destination_state,
            'commodity_id' => $request->commodity,
            'dispatch_time' => $request->dispatch_time,
            'estimated_arrival_time' => $request->estimated_arrival_time,
            'logistics_company' => $request->logistics_company,
            'status_id' => 3,
            'created_by' => Auth::id()
        );
        try {
            $result = DB::table('dispatch')->insert($data);
            if ($result) {
                return response()->json(['status' => 1, 'msg' => 'New Dispatch has been successfully created.']);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']);
        }
    }
    public function getDeliveryDetails($id)
    {

        return view('delivery.view', ['delivery' => Delivery::find($id)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dispatch  $dispatch
     * @return \Illuminate\Http\Response
     */
    public function show(Dispatch $dispatch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dispatch  $dispatch
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dispatch = Dispatch::find($id);
        return response()->json(['details' => $dispatch]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dispatch  $dispatch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dispatch $dispatch)
    {
        $validator = Validator::make($request->all(), [
            'trade' => 'required|numeric',
            'aggregator' => 'required|numeric',
            'number_of_bags' => 'required|numeric',
            'truck_number' => 'required|max:8',
            'driver_name' => 'required|max:255',
            'driver_phone_number' => 'required|digits:11',
            'pickup_state' => 'required|numeric',
            'destination_state' => 'required|numeric',
            'commodity' => 'required|numeric',
            'estimated_arrival_time' => 'required|date_format:Y-m-d',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }

        $data = array(
            'trade_id' => $request->trade,
            'aggregator_id' => $request->aggregator,
            'number_of_bags' => $request->number_of_bags,
            'truck_number' => $request->truck_number,
            'driver_name' => $request->driver_name,
            'driver_number' => $request->driver_phone_number,
            'pickup_state_id' => $request->pickup_state,
            'destination_state_id' => $request->destination_state,
            'commodity_id' => $request->commodity,
            'dispatch_time' => $request->dispatch_time,
            'estimated_arrival_time' => $request->estimated_arrival_time,
            'logistics_company' => $request->logistics_company,
            'status_id' => 3,
            'updated_by' => Auth::id(),
        );

        try {

            DB::enableQueryLog();
            $result = DB::table('dispatch')->where('id', $request->id)->update($data);
            //dd(DB::getQueryLog());

            return response()->json(['status' => 1, 'msg' => 'dispatch details has been successfully Updated.']);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dispatch  $dispatch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dispatch $dispatch)
    {
        //
    }

    public function getDispatchDetail($id)
    {
        $dispatchDetails = DB::select('SELECT aggregator.name aggregator, commodity.name commodity, partner.name partner,
                                trade.aggregator_price, trade.food_processor 
                                FROM dispatch inner join  trade on dispatch.trade_id = trade.id 
                                inner join aggregator on aggregator.id = dispatch.aggregator_id 
                                inner join partner on partner.id =  trade.partner_id
                                inner join commodity  on commodity.id = trade.commodity_id
                                WHERE dispatch.id=?', [$id]);
        return json_encode($dispatchDetails[0]);
    }
}
