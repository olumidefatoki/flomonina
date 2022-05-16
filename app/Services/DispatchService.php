<?php

namespace App\Services;

use DataTables;
use App\Models\State;
use App\Models\Trade;
use App\Models\Status;
use App\Models\CodeGen;
use App\Models\Delivery;
use App\Models\Dispatch;
use App\Models\Commodity;
use App\Models\Aggregator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DispatchService
{


    public function create($request)
    {
        $codeGen = CodeGen::find(1);
        $code = $codeGen->prefix . '/' .  $codeGen->next_num;
        $data = array('next_num' => sprintf('%06d', $codeGen->next_num + 1));
        $updateResult = DB::table('code_gen')->where('id', 1)->update($data);

        if (empty($request->dispatch_time)) {
            $request->dispatch_time = now();
        }
        $data = array(
            'code' => $code,
            'trade_id' => $request->trade,
            'aggregator_id' => $request->aggregator,
            'number_of_bags' => $request->number_of_bags,
            'truck_number' => $request->truck_number,
            'driver_name' => $request->driver_name,
            'driver_number' => $request->driver_phone_number,
            'pickup_state_id' => $request->pickup_state,
            'destination_state_id' => $request->destination_state,
            'commodity_id' => $request->commodity,
            'dispatch_time' => $request->dispatch_time,
            'estimated_arrival_time' => $request->estimated_arrival_time,
            'logistics_company' => $request->logistics_company,
            'status_id' => 3,
            'created_by' => Auth::id()
        );

        return DB::table('dispatch')->insert($data);
    }

    public function getAllDispatchs($request)
    {
        $dispatchs = Dispatch::join('trade', 'trade.id', '=', 'dispatch.trade_id')
            ->join('partner', 'partner.id', '=', 'trade.partner_id')
            ->join('state as pickupState', 'pickupState.id', '=', 'dispatch.pickup_state_id')
            ->join('state as destState', 'destState.id', '=', 'dispatch.destination_state_id')
            ->join('status', 'status.id', '=', 'dispatch.status_id')
            ->join('aggregator', 'aggregator.id', '=', 'dispatch.aggregator_id')
            ->join('commodity', 'commodity.id', '=', 'dispatch.commodity_id');
        if (!is_null($request['code'])) {
            $dispatchs->where('dispatch.code', '=', $request['code']);
        }
        if (!is_null($request['truck_number'])) {
            $dispatchs->where('dispatch.truck_number', '=', $request['truck_number']);
        }
        if (!is_null($request['commodity_id'])) {
            $dispatchs->where('dispatch.commodity_id', '=', $request['commodity_id']);
        }
        if (!is_null($request['aggregator_id'])) {
            $dispatchs->where('dispatch.aggregator_id', '=', $request['aggregator_id']);
        }
        if (!is_null($request['status_id'])) {
            $dispatchs->where('dispatch.status_id', '=', $request['status_id']);
        }
        if (!is_null($request['start_date']) && !is_null($request['end_date'])) {
            $startDate = $request['start_date'] . ' 00:00:00';
            $endDate   = $request['end_date'] . ' 23:59:59';
            $dispatchs->whereBetween('dispatch.created_at', array($startDate, $endDate));
        }
        $dispatchs->orderBy('dispatch.uploaded_at', 'desc');
        $dispatchs->select(
            'dispatch.*',
            'partner.name As partner',
            'pickupState.name As pickupstate',
            'destState.name As destState',
            'status.name As status',
            'aggregator.name As aggregator',
            'commodity.name As commodity'
        );

        $dispatchs;
        return DataTables::of($dispatchs)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                                                <button class="btn btn-sm btn-info" data-id="' . $row['id'] . '" id="editDispatchBtn">Edit</button> 
                                          </div>';
            })->editColumn('created_at', function ($item) {
                
                return date('Y-m-d H:m:s', strtotime($item->created_at));
            })->editColumn('estimated_arrival_time', function ($item) {
                return date('Y-m-d', strtotime($item->estimated_arrival_time));
            })->editColumn('dispatch_time', function ($item) {
                return date('Y-m-d', strtotime($item->dispatch_time));
            })
            ->editColumn('number_of_bags', function ($item) {
                return number_format($item->number_of_bags);
            })->rawColumns(['actions'])
            ->make(true);
    }

    public function update($request)
    {
        $data = array(
            'trade_id' => $request->trade,
            'aggregator_id' => $request->aggregator,
            'number_of_bags' => $request->number_of_bags,
            'truck_number' => $request->truck_number,
            'driver_name' => $request->driver_name,
            'driver_number' => $request->driver_phone_number,
            'pickup_state_id' => $request->pickup_state,
            'destination_state_id' => $request->destination_state,
            'commodity_id' => $request->commodity,
            'dispatch_time' => $request->dispatch_time,
            'estimated_arrival_time' => $request->estimated_arrival_time,
            'logistics_company' => $request->logistics_company,
            'status_id' => 3,
            'updated_by' => Auth::id(),
        );
      return  DB::table('dispatch')->where('id', $request->id)->update($data);
    }
}
