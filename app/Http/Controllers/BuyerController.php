<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use Exception;
use App\Models\Buyer;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class BuyerController extends Controller
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
        return view('buyer.index',
            ['states'=>$states
        ]);
    }

    public function getBuyerList(Request $request){
        $buyers = Buyer::join('state', 'state.id', '=', 'buyer.state_id')
                ->orderBy('buyer.id', 'desc')
                ->get(['buyer.*', 'state.name AS state_name']);
        return DataTables::of($buyers)
                              ->addIndexColumn()
                              ->addColumn('actions', function($row){
                                  return '<div class="btn-group">
                                                <button class="btn btn-sm btn-info" data-id="'.$row['id'].'" id="editBuyerBtn">Edit</button> 
                                          </div>';
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
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255|unique:buyer',
            'address' => 'required|max:255',
            'contact_person_first_name' => 'required|max:255',
            'contact_person_email' => 'required|email|max:255|unique:buyer',
            'contact_person_phone_number' => 'required|digits:11|unique:buyer',
            'state' => 'required|numeric'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }

        $data = array(
            'name' => $request->name, 'address' => $request->address,
            'contact_person_first_name' => $request->contact_person_first_name,
            'contact_person_last_name' => $request->contact_person_last_name,
            'state_id' => $request->state,
            'contact_person_phone_number' => $request->contact_person_phone_number,
            'contact_person_email' => $request->contact_person_email,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        );
        $result = DB::table('buyer')->insert($data);
        if( $result ){
            return response()->json(['status'=>1, 'msg'=>'New Buyer has been successfully created.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $buyerDetails = Buyer::find($id);
        return response()->json(['details'=>$buyerDetails]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buyer $buyer)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'contact_person_first_name' => 'required|max:255',
            'contact_person_email' => 'required|email|max:255',
            'contact_person_phone_number' => 'required|digits:11|',
            'state' => 'required|numeric'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
        try {
            $buyer = Buyer::find($request->id);

            $buyerRecordByEmail =  Buyer::where('contact_person_email',$request->contact_person_email)->first();
            if($buyerRecordByEmail && ($buyerRecordByEmail->id != $buyer->id)){
                return response()->json(['status'=>0, 'error'=>array( 'contact_person_email'=>array('The contact person email already exist in the database.'))]);
            }

            $buyerRecordByPhoneNo =  Buyer::where('contact_person_phone_number',$request->contact_person_phone_number)->first();
            if($buyerRecordByPhoneNo && ($buyerRecordByPhoneNo->id != $buyer->id)){
                return response()->json(['status'=>0, 'error'=>array( 'contact_person_phone_number'=>array('The contact person phone number already exist in the database.'))]);
            }

            $buyer->name= $request->name;
            $buyer->address= $request->address;
            $buyer->contact_person_first_name= $request->contact_person_first_name;
            $buyer->contact_person_last_name= $request->contact_person_last_name;
            $buyer->contact_person_phone_number= $request->contact_person_phone_number;
            $buyer->contact_person_email= $request->contact_person_email;
            $buyer->state_id= $request->state;
            $buyer->updated_by = Auth::id();
            $result = $buyer->save();
        if($result )
        return response()->json(['status'=>1, 'msg'=>'Buyer Details have Been updated']);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json(['status'=>2, 'msg'=>'Something went wrong. Kindly contact the Admin.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buyer $buyer)
    {
        //
    }
}
