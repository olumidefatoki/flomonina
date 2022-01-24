<?php

namespace App\Services;

use Exception;
use DataTables;
use App\Models\State;
use App\Models\Trade;
use App\Models\Status;
use App\Models\CodeGen;
use App\Models\Partner;
use App\Models\Delivery;
use App\Models\Dispatch;
use App\Models\Commodity;

use App\Models\Aggregator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

class TradeService
{


    public function create($request)
    {

        if (empty($request->date)) {
            $request->date = now();
        }
        $data = array(
            'partner_id' => $request->partner,
            'type' => $request->type,
            'description' => $request->description,
            'prefunded_amount' => $request->prefunded_amount,
            'quantity' => $request->quantity,
            'margin' => $request->margin,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status_id' => 2,
            'created_at' => $request->date,
            'created_by' => Auth::id(),
        );
        try {
            return DB::table('trade')->insert($data);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $response = response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']);
            throw new HttpResponseException($response);
        }
    }

    public function getAllTrades($request)
    {
        $trades = Trade::join('partner', 'partner.id', '=', 'trade.partner_id')
            ->join('status', 'status.id', '=', 'trade.status_id')
            ->join('users', 'users.id', '=', 'trade.created_by')
            ->orderBy('trade.created_at', 'desc')
            ->get([
                'trade.*',  'status.name As status', 'users.name As created_by', 'partner.name As partner'
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
            })->editColumn('prefunded_amount', function ($item) {
                return number_format($item->prefunded_amount);
            })->editColumn('created_at', function ($item) {
                if (empty($item->created_at))
                    return $item->created_at;
                return date('Y-m-d H:i:s', strtotime($item->created_at));
            })->editColumn('start_date', function ($item) {
                return date('Y-m-d', strtotime($item->start_date));
            })->editColumn('end_date', function ($item) {
                return date('Y-m-d', strtotime($item->end_date));
            })
            ->make(true);
    }

    public function update($request)
    {
        $data = array(
            'partner_id' => $request->partner,
            'type' => $request->type,
            'prefunded_amount' => $request->prefunded_amount,
            'quantity' => $request->quantity,
            'margin' => $request->margin,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'updated_by' => Auth::id(),
        );

        try {
            return  DB::table('trade')->where('id', $request->id)->update($data);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $response = response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']);
            throw new HttpResponseException($response);
        }
    }
}
