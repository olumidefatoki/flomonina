<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use Exception;
use App\Models\Delivery;
use App\Models\Dispatch;
use App\Models\State;
use App\Models\Aggregator;
use App\Models\Partner;
use App\Models\Commodity;
use App\Models\Buyer;
use App\Rules\DecimalValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
        $commodities = Commodity::all();
        $aggregator = Aggregator::all();
        $partners = Partner::all();
        return view(
            'delivery.index',
            [
                'dispatchs' => $dispatchs,
                'commodities' => $commodities,
                'aggregator' => $aggregator,
                'partners' => $partners,
            ]
        );
    }
    public function getDeliveryList(Request $request)
    {
        $deliveries = Delivery::join('dispatch', 'dispatch_id', '=', 'dispatch.id')
            ->join('trade', 'trade.id', '=', 'dispatch.trade_id')
            ->join('aggregator', 'aggregator.id', '=', 'dispatch.aggregator_id')
            ->join('partner', 'partner.id', '=', 'trade.partner_id')
            ->join('commodity', 'commodity.id', '=', 'trade.commodity_id')
            ->join('status', 'status.id', '=', 'delivery.status_id')
            ->orderBy('dispatch.created_at', 'desc')
            ->get([
                'delivery.*', 'trade.price', 'dispatch.truck_number', 'trade.food_processor As processor',
                'partner.name As partner', 'status.name As status',
                'aggregator.name As aggregator', 'commodity.name As commodity'
            ]);
        return DataTables::of($deliveries)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                                                <button class="btn btn-sm btn-info" data-id="' . $row['id'] . '" id="editDeliveryBtn">Edit</button>  
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="/delivery/details/' . $row['id'] . '"> <button class="btn btn-sm btn-info" data-id="' . $row['id'] . '" >View</button> </a>
                                          </div>';
            })->rawColumns(['actions'])
            ->editColumn('accepted_quantity', function ($item) {
                return number_format($item->accepted_quantity);
            })->editColumn('aggregator_amount', function ($item) {
                return number_format($item->aggregator_price * $item->accepted_quantity);
            })->editColumn('discounted_amount', function ($item) {
                return number_format($item->partner_price * $item->accepted_quantity);
            })->editColumn('created_at', function ($item) {
                if (empty($item->created_at))
                    return $item->created_at;
                return date('Y-m-d H:i:s', strtotime($item->created_at));
            })
            ->make(true);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dispatch' => 'required|numeric',
            'accepted_quantity' => ['required', new DecimalValidator()],
            'no_of_bags_rejected' => 'required|numeric',
            'aggregator_price' => ['required', new DecimalValidator()],
            'discounted_price' => ['required', new DecimalValidator()],
            'way_ticket' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }

        $trade = Dispatch::join('trade', 'trade_id', '=', 'trade.id')
            ->join('aggregator', 'aggregator_id', '=', 'aggregator.id')
            ->join('partner', 'partner_id', '=', 'partner.id')
            ->where('dispatch.id', '=', $request->dispatch)
            ->get(['trade.price', 'aggregator.name As aggregator', 'partner.name As partner'])
            ->first();


        if ($request->partner_price > $trade->price) {
            return response()->json(['status' => 0, 'error' => array('partner_price' => array('The Partner Price is greater than the Order Price. '))]);
        }

        $path = 'tickets';
        $file = $request->file('way_ticket');
        $file_name = $trade->partner . '_' . $trade->aggregator . '_' . date('YmdHis') .  '.' . $file->extension();


        $upload = $file->storeAs($path, $file_name, 'public');

        if (empty($request->date)) {
            $request->date = now();
        }

        if ($upload) {
            $data = array(
                'dispatch_id' => $request->dispatch,
                'accepted_quantity' => $request->accepted_quantity,
                'no_of_bags_rejected' => $request->no_of_bags_rejected,
                'aggregator_price' => $request->aggregator_price,
                'discounted_price' => $request->discounted_price,
                'way_ticket' => $upload,
                'trade_price' => $trade->price,
                'margin' => $trade->price - $request->aggregator_price - $request->discounted_price,
                'status_id' => 8,
                'created_at' => $request->date,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            );
            $result = DB::table('delivery')->insert($data);
            $dispatch = array('status_id' => 5);
            DB::table('dispatch')->where('id', $request->dispatch)->update($dispatch);
            if ($result) {
                return response()->json(['status' => 1, 'msg' => 'Way Ticket has been successfully upload.']);
            }
        }
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
            'accepted_quantity' => ['required', new DecimalValidator()],
            'no_of_bags_rejected' => 'required|numeric',
            'partner_price' => ['required', new DecimalValidator()],
            'discounted_price' => ['required', new DecimalValidator()],
            'way_ticket' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
                'no_of_bags_rejected' => $request->no_of_bags_rejected,
                'partner_price' => $request->partner_price,
                'discounted_price' => $request->discounted_price,
                'way_ticket' => $upload,
                'order_price' => 0,
                'revenue_price' => 0,
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
