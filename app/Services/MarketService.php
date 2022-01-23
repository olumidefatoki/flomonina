<?php

namespace App\Services;

use Exception;
use DataTables;
use App\Models\Market;
use App\Models\Aggregator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

class MarketService
{

    public function create($request)
    {
        $data = array(
            'name' => $request->name,
            'address' => $request->address,
            'state_id' => $request->state,
            'lga_id' => $request->lga,
            'created_at' => now(),
            'created_by' => Auth::id()
        );
        try {
            $result = DB::table('market')->insert($data);
            return $result;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            throw new HttpResponseException(response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']));
        }
    }

    public function getAllMarkets($request)
    {
        $markets = Market::join('lga', 'lga.id', '=', 'market.lga_id')
            ->join('state', 'state.id', '=', 'lga.state_id')
            ->join('users', 'users.id', '=', 'market.created_by');

        if (!is_null($request['state_id'])) {
            $markets->where('market.state_id', '=', $request['state_id']);
        }
        if (!is_null($request['name'])) {
            $markets->where('market.name', '=', $request['name']);
        }

        $markets->orderBy('market.created_at', 'desc');
        $markets->select(
            'market.name',
            'market.address',
            'state.name As state',
            'lga.name as lga',
            'users.name As created_by',
        );
        return DataTables::of($markets)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                                                <button class="btn btn-sm btn-info" data-id="' . $row['id'] . '" id="editDeliveryBtn">Edit</button>  
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="/delivery/details/' . $row['id'] . '"> <button class="btn btn-sm btn-info" data-id="' . $row['id'] . '" >View</button> </a>
                                          </div>';
            })->rawColumns(['actions'])            
            ->make(true);
    }

    public function update($request)
    {
    }
}
