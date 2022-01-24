<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTradeRequest;
use App\Http\Requests\UpdateTradeRequest;
use Validator;
use DataTables;
use Exception;
use App\Models\Trade;
use App\Models\State;
use App\Models\Partner;
use App\Models\Commodity;
use App\Rules\DecimalValidator;
use App\Services\TradeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TradeController extends Controller
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
        $states = State::all();
        $commodities = Commodity::all();
        $partners = Partner::all();
        //DB::enableQueryLog();
        $processors = Partner::where('type', 'processor')->get();
        //dd(DB::getQueryLog());
        return view('trade.index', [
            'states' => $states,
            'partners' => $partners,
            'commodities' => $commodities,
            'processors' => $processors
        ]);
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

    public function getTradeList(Request $request, TradeService $service)
    {
        return $service->getAllTrades($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTradeRequest $request, TradeService $service)
    {
        if ($service->create($request))
            return response()->json(['status' => 1, 'msg' => 'New Trade has been successfully created.']);
        return response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function show(Trade $trade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trade = Trade::find($id);
        return response()->json(['details' => $trade]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTradeRequest $request,  TradeService $service)
    {

        if ($service->update($request))
            return response()->json(['status' => 1, 'msg' => 'Trade has been successfully Updated.']);
        return response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trade $trade)
    {
        //
    }
}
