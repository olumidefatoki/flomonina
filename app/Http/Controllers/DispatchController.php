<?php

namespace App\Http\Controllers;

use Exception;
use Validator;
use DataTables;
use App\Models\State;
use App\Models\Trade;
use App\Models\Status;
use App\Models\CodeGen;
use App\Models\Delivery;
use App\Models\Dispatch;
use App\Models\Commodity;
use App\Models\Aggregator;
use Illuminate\Http\Request;
use App\Services\DispatchService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateDispatchRequest;
use App\Http\Requests\UpdateDispatchRequest;



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
        return view('dispatch.index', [
            'trades' => Trade::all(),
            'aggregators' => Aggregator::all(),
            'states' => State::all(),
            'commodities' => Commodity::all(),
            'status' => status::find([3, 5]),
        ]);
    }

    public function getDispatchList(Request $request, DispatchService $service)
    {
        return  $service->getAllDispatchs($request);
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
    public function store(CreateDispatchRequest $request, DispatchService $service)
    {
        $dataCount = Dispatch::where('truck_number', $request->truck_number)
            ->where('status_id', 3)
            ->count();
        if ($dataCount > 1) {
            return response()->json(['status' => 0, 'error' => array('truck_number' => array('truck number is already on Transit.'))]);
        }

        try {
            $result = $service->create($request);
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
    public function update(UpdateDispatchRequest $request, DispatchService $service)
    {
        $dataCount = Dispatch::where('truck_number', $request->truck_number)
            ->where('status_id', 3)
            ->count();
        if ($dataCount > 1) {
            return response()->json(['status' => 0, 'error' => array('truck_number' => array('truck number is already on Transit.'))]);
        }

        try {
            $result = $service->update($request);
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
