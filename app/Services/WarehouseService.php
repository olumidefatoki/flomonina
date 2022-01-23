<?php

namespace App\Services;

use Exception;
use DataTables;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

class WarehouseService
{

    public function create($request, $type)
    {
        $data = array(
            'name' => $request->name,
            'address' => $request->address,
            'description' => $request->description,
            'type' => $type,
            'state_id' => $request->state,
            'lga_id' => $request->lga,
            'created_at' => now(),
            'created_by' => Auth::id()
        );
        try {
            $result = DB::table('warehouse')->insert($data);
            return $result;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            throw new HttpResponseException(response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']));
        }
    }

    public function getAllWarehouses($request, $type)
    {
        $warehouses = Warehouse::join('lga', 'lga.id', '=', 'warehouse.lga_id')
            ->join('state', 'state.id', '=', 'lga.state_id')
            ->join('users', 'users.id', '=', 'warehouse.created_by');

        $warehouses->where('warehouse.type', '=', $type);

        if (!is_null($request['state_id'])) {
            $warehouses->where('warehouse.state_id', '=', $request['state_id']);
        }
        if (!is_null($request['name'])) {
            $warehouses->where('warehouse.name', '=', $request['name']);
        }

        $warehouses->orderBy('warehouse.created_at', 'desc');
        $warehouses->select(
            'warehouse.name',
            'warehouse.address',
            'warehouse.description',
            'state.name As state',
            'lga.name as lga',
            'users.name As created_by',
        );
        return DataTables::of($warehouses)
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
