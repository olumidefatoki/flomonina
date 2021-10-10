<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use Exception;
use App\Models\Trade;
use App\Models\State;
use App\Models\Partner;
use App\Models\Commodity;
use App\Rules\DecimalValidator;
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

    public function getTradeList(Request $request)
    {
        $trades = Trade::join('state', 'state.id', '=', 'trade.state_id')
            ->join('partner', 'partner.id', '=', 'trade.partner_id')
            ->join('commodity', 'commodity.id', '=', 'trade.commodity_id')
            ->join('status', 'status.id', '=', 'trade.status_id')
            ->join('users', 'users.id', '=', 'trade.created_by')
            ->orderBy('trade.created_at', 'desc')
            ->get([
                'trade.*', 'state.name AS state_name', 'status.name As status', 'users.name As created_by',
                'partner.name As partner', 'commodity.name As commodity_name'
            ]);
        return DataTables::of($trades)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                                                <button class="btn btn-sm btn-info" data-id="' . $row['id'] . '" id="editTradeBtn">Edit</button> 
                                          </div>';
            })->rawColumns(['actions'])
            ->editColumn('quantity', function ($item) {
                return number_format($item->quantity);
            })->editColumn('created_at', function ($item) {
                if (empty($item->created_at))
                    return $item->created_at;
                return date('Y-m-d H:i:s', strtotime($item->created_at));
            })->editColumn('updated_at', function ($item) {
                if (empty($item->updated_at))
                    return $item->updated_at;
                return date('Y-m-d H:i:s', strtotime($item->updated_at));
            })
            ->editColumn('start_date', function ($item) {
                return date('Y-m-d', strtotime($item->start_date));
            })->editColumn('end_date', function ($item) {
                return date('Y-m-d', strtotime($item->end_date));
            })
            ->make(true);
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
            'partner' => 'required|numeric',
            'processor' => 'required',
            'address' => 'required|max:255',
            'quantity' => ['required', new DecimalValidator()],
            'price' => ['required', new DecimalValidator()],
            'commodity' => 'required|numeric',
            'state' => 'required|numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }

        if (empty($request->date)) {
            $request->date = now();
        }

        $data = array(
            'partner_id' => $request->partner,
            'food_processor' => $request->processor,
            'delivery_location' => $request->address,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'commodity_id' => $request->commodity,
            'state_id' => $request->state,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status_id' => 2,
            'created_at' => $request->date,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        );
        $result = DB::table('trade')->insert($data);
        if ($result) {
            return response()->json(['status' => 1, 'msg' => 'New Trade has been successfully created.']);
        }
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
    public function update(Request $request, Trade $trade)
    {
        $validator = Validator::make($request->all(), [
            'partner' => 'required|numeric',
            'processor' => 'required',
            'address' => 'required|max:255',
            'quantity' => ['required', new DecimalValidator()],
            'price' => ['required', new DecimalValidator()],
            'commodity' => 'required|numeric',
            'state' => 'required|numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }
        $data = array(
            'partner_id' => $request->partner,
            'food_processor' => $request->processor,
            'delivery_location' => $request->address,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'commodity_id' => $request->commodity,
            'state_id' => $request->state,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'updated_by' => Auth::id(),
        );
        try {
            DB::enableQueryLog();
            $result = DB::table('trade')->where('id', $request->id)->update($data);
            //dd(DB::getQueryLog());
            return response()->json(['status' => 1, 'msg' => 'Trade has been successfully Updated.']);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']);
        }
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
