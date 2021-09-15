<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use Exception;
use App\Models\Partner;
use App\Models\State;
use App\Models\Bank;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PartnerController extends Controller
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
        $banks = Bank::all();
        return view('partner.index',
            ['states'=>$states,
            'banks' => $banks
        ]);
    }

     public function getPartnerList(Request $request){
        $partners = Partner::join('state', 'state.id', '=', 'partner.state_id')
                ->orderBy('partner.id', 'desc')
                ->get(['partner.*', 'state.name AS state_name']);
        return DataTables::of($partners)
                              ->addIndexColumn()
                              ->addColumn('actions', function($row){
                                  return '<div class="btn-group">
                                                <button class="btn btn-sm btn-info" data-id="'.$row['id'].'" id="editPartnerBtn">Edit</button> 
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
            'name' => 'required|max:255|unique:partner',
            'address' => 'required|max:255',
            'contact_person_name' => 'required|max:255',
            'contact_person_email' => 'required|email|max:255|unique:partner',
            'contact_person_phone_number' => 'required|digits:11|unique:partner',
            'state' => 'required|numeric',
            'bank' => 'required|numeric',
            'account_name' => 'required|max:255',
            'account_number' => 'required|digits:11'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }

        $data = array(
            'name' => $request->name, 
            'address' => $request->address,
            'contact_person_name' => $request->contact_person_name,
            'state_id' => $request->state,
            'contact_person_phone_number' => $request->contact_person_phone_number,
            'contact_person_email' => $request->contact_person_email,
            'bank_id' => $request->bank,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        );
        $result = DB::table('partner')->insert($data);
        if( $result ){
            return response()->json(['status'=>1, 'msg'=>'New Buyer has been successfully created.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partnerDetails = Partner::find($id);
        return response()->json(['details'=>$partnerDetails]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'contact_person_name' => 'required|max:255',
            'contact_person_email' => 'required|email|max:255',
            'contact_person_phone_number' => 'required|digits:11',
            'state' => 'required|numeric',
            'bank' => 'required|numeric',
            'account_name' => 'required|max:255',
            'account_number' => 'required|digits:11'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
        $partner = Partner::find($request->id);
        $partnerRecordByEmail =  Partner::where('contact_person_email',$request->contact_person_email)->first();
        if($partnerRecordByEmail && ($partnerRecordByEmail->id != $partner->id)){
                return response()->json(['status'=>0, 'error'=>array( 'contact_person_email'=>array('The contact person email already exist in the database.'))]);
        }

        $partnerRecordByPhoneNo =  Partner::where('contact_person_phone_number',$request->contact_person_phone_number)->first();
        if($partnerRecordByPhoneNo && ($partnerRecordByPhoneNo->id != $partner->id)){
                return response()->json(['status'=>0, 'error'=>array( 'contact_person_phone_number'=>array('The contact person phone number already exist in the database.'))]);
        }

        $data = array(
            'name' => $request->name, 
            'address' => $request->address,
            'contact_person_name' => $request->contact_person_name,
            'state_id' => $request->state,
            'contact_person_phone_number' => $request->contact_person_phone_number,
            'contact_person_email' => $request->contact_person_email,
            'bank_id' => $request->bank,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'updated_by' => Auth::id(),
        );
        try{
            $result = DB::table('partner')->where('id', $request->id)->update($data);
            
            return response()->json(['status'=>1, 'msg'=>'Partner details has been successfully Updated.']);
        }    
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json(['status'=>2, 'msg'=>'Something went wrong. Kindly contact the Admin.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        //
    }
}
