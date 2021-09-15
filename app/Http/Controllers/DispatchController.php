<?php

namespace App\Http\Controllers;

use App\Models\Dispatch;
use App\Models\State;
use App\Models\BuyerOrder;
use App\Models\Partner;
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
        $buyerOrders = BuyerOrder::all();
        $partners = Partner::all();
        $states = State::all();
        return view('dispatch.index',[
            'buyerOrders'=>$buyerOrders,
            'partners'=>$partners,
            'states'=>$states,
        ]);
    }

    public function getDispatchList(Request $request){
        $dispatchs = Dispatch::join('buyer_order','buyer_order_id' ,'=','buyer_order.id')
                                    ->join('partner', 'partner.id', '=', 'dispatch.partner_id')
                                    ->join('buyer', 'buyer.id', '=', 'buyer_order.buyer_id')
                                    ->join('commodity', 'commodity.id', '=', 'buyer_order.commodity_id')
                                    ->orderBy('buyer_order.id', 'desc')
                                    ->get(['buyer_order.*', 'dispatch.*', 'partner.name As partner_name',
                                            'buyer.name As buyer_name','commodity.name As commodity_name']);
        return DataTables::of($dispatchs)                                
                              ->addIndexColumn()
                              ->addColumn('actions', function($row){
                                  return '<div class="btn-group">
                                                <button class="btn btn-sm btn-info" data-id="'.$row['id'].'" id="editDispatchBtn">Edit</button> 
                                          </div>';
                              })->rawColumns(['actions'])
                              ->editColumn('number_of_bags', function($item) {
                                return number_format($item->number_of_bags);
                            })->make(true);
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
            'order' => 'required|numeric',
            'partner' => 'required|numeric',
            'number_of_bags' => 'required|numeric',
            'truck_number' => 'required|max:8',
            'driver_name' => 'required|max:255',
            'driver_phone_number' => 'required|digits:11',
            'state' => 'required|numeric',
            'dispatch_location' => 'required|max:255',
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }

        $data = array(
            'buyer_order_id' => $request->order,
            'partner_id' => $request->partner,
            'number_of_bags' => $request->number_of_bags,
            'truck_number' => $request->truck_number,
            'driver_name' => $request->driver_name,
            'driver_number' => $request->driver_phone_number,
            'state_id' => $request->state,
            'dispatch_location' => $request->dispatch_location,
            'status_id' => 3,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        );
        $result = DB::table('dispatch')->insert($data);
        if( $result ){
            return response()->json(['status'=>1, 'msg'=>'New Dispatch has been successfully created.']);
        }
    }
    public function getDeliveryDetails($id)
    {

        return view('delivery.view',['delivery'=>Delivery::find($id)]);

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
        return response()->json(['details'=>$dispatch]);
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
        
        $validator = Validator::make($request->all(),[
            'order' => 'required|numeric',
            'partner' => 'required|numeric',
            'number_of_bags' => 'required|numeric',
            'truck_number' => 'required|max:8',
            'driver_name' => 'required|max:255',
            'driver_phone_number' => 'required|digits:11',
            'state' => 'required|numeric',
            'dispatch_location' => 'required|max:255',
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }

        $data = array(
            'buyer_order_id' => $request->order,
            'partner_id' => $request->partner,
            'number_of_bags' => $request->number_of_bags,
            'truck_number' => $request->truck_number,
            'driver_name' => $request->driver_name,
            'driver_number' => $request->driver_phone_number,
            'state_id' => $request->state,
            'dispatch_location' => $request->dispatch_location,
            'status_id' => 3,
            'updated_by' => Auth::id(),
        );

        try{

            DB::enableQueryLog();
            $result = DB::table('dispatch')->where('id', $request->id)->update($data);
            //dd(DB::getQueryLog());
            
            return response()->json(['status'=>1, 'msg'=>'dispatch details has been successfully Updated.']);
        }    
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json(['status'=>2, 'msg'=>'Something went wrong. Kindly contact the Admin.']);
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
        $dispatchDetails = DB::select('SELECT buyer.name buyer, commodity.name commodity, partner.name partner
                                FROM dispatch inner join  buyer_order on dispatch.buyer_order_id = buyer_order.id 
                                inner join buyer on buyer.id = buyer_order.buyer_id 
                                inner join partner on partner.id =  dispatch.partner_id
                                inner join commodity  on commodity.id = buyer_order.commodity_id
                                WHERE dispatch.id=?', [$id]);
        return json_encode($dispatchDetails[0]);
    }
}
