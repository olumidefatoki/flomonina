<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use Exception;
use App\Models\BuyerOrder;
use App\Models\State;
use App\Models\Buyer;
use App\Models\Commodity;
use App\Rules\DecimalValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class BuyerOrderController extends Controller
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
        $buyers = Buyer::all();
        return view('orders.index',[
          'states'=>$states,
          'buyers'=>$buyers,
          'commodities'=>$commodities  
        ]);
    }

    public function getOrderList(Request $request){
        $buyerOrders = BuyerOrder::join('state', 'state.id', '=', 'buyer_order.state_id')
                                    ->join('buyer', 'buyer.id', '=', 'buyer_order.buyer_id')
                                    ->join('commodity', 'commodity.id', '=', 'buyer_order.commodity_id')
                                    ->join('status', 'status.id', '=', 'buyer_order.status_id')
                                    ->orderBy('buyer_order.id', 'desc')
                                    ->get(['buyer_order.*', 'state.name AS state_name','status.name As status',
                                            'buyer.name As buyer_name','commodity.name As commodity_name']);
        return DataTables::of($buyerOrders)
                              ->addIndexColumn()
                              ->addColumn('actions', function($row){
                                  return '<div class="btn-group">
                                                <button class="btn btn-sm btn-info" data-id="'.$row['id'].'" id="editOrderBtn">Edit</button> 
                                          </div>';
                              })->rawColumns(['actions'])
                              ->editColumn('quantity', function($item) {
                                return number_format($item->quantity);
                            })
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
        $validator = Validator::make($request->all(),[
            'buyer' => 'required|numeric',
            'address' => 'required|max:255',
            'quantity' => ['required', new DecimalValidator()],
            'price' => ['required', new DecimalValidator()],
            'commodity' => 'required|numeric',
            'state' => 'required|numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }

        $data = array(
                    'buyer_id' => $request->buyer,
                    'code' => rand(1,50000000),
                    'delivery_location' => $request->address,
                    'quantity' => $request->quantity,
                    'price' => $request->price,
                    'commodity_id' => $request->commodity,
                    'state_id' => $request->state,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'status_id' => 2,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
        );
        $result = DB::table('buyer_order')->insert($data);
        if( $result ){
            return response()->json(['status'=>1, 'msg'=>'New Order has been successfully created.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BuyerOrder  $buyerOrder
     * @return \Illuminate\Http\Response
     */
    public function show(BuyerOrder $buyerOrder)
    {
        $buyerOrder = BuyerOrder::find($id);
        return response()->json(['details'=>$buyerOrder]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BuyerOrder  $buyerOrder
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $buyerOrder = BuyerOrder::find($id);
        return response()->json(['details'=>$buyerOrder]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuyerOrder  $buyerOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuyerOrder $buyerOrder)
    {
        $validator = Validator::make($request->all(),[
            'buyer' => 'required|numeric',
            'address' => 'required|max:255',
            'quantity' => ['required', new DecimalValidator()],
            'price' => ['required', new DecimalValidator()],
            'commodity' => 'required|numeric',
            'state' => 'required|numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
        $data = array(
            'buyer_id' => $request->buyer,
            'delivery_location' => $request->address,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'commodity_id' => $request->commodity,
            'state_id' => $request->state,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'updated_by' => Auth::id(),
);
        try{
            DB::enableQueryLog();
            $result = DB::table('buyer_order')->where('id', $request->id)->update($data);
            //dd(DB::getQueryLog());
            return response()->json(['status'=>1, 'msg'=>'Order has been successfully Updated.']);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json(['status'=>2, 'msg'=>'Something went wrong. Kindly contact the Admin.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BuyerOrder  $buyerOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuyerOrder $buyerOrder)
    {
        //
    }
}
