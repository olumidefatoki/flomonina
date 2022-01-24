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

class DeliveryService
{


    public function create($request)
    {
        $trade = Dispatch::join('trade', 'trade_id', '=', 'trade.id')
            ->join('aggregator', 'dispatch.aggregator_id', '=', 'aggregator.id')
            ->join('partner', 'trade.partner_id', '=', 'partner.id')
            ->where('dispatch.id', '=', $request->dispatch)
            ->get(['aggregator.name As aggregator', 'partner.name As partner'])
            ->first();
        $path = 'upload/tickets/food_processor';
        $file = $request->file('way_ticket');
        $file_name = $trade->partner . '_' . $trade->aggregator . '_' . date('YmdHis') .  '.' . $file->extension();
        $upload = $file->move($path, $file_name);

        if (empty($request->date)) {
            $request->date = now();
        }

        $data = array(
            'dispatch_id' => $request->dispatch,
            'commodity_id' => $request->commodity,
            'accepted_quantity' => $request->accepted_quantity,
            'aggregator_price' => $request->aggregator_price,
            'discounted_price' => $request->discounted_price,
            'trade_price' => $request->processor_price,
            'processor' => Partner::find($request->processor)->name,
            'partner_id' => $request->processor,
            'way_ticket' => $upload,
            'margin' => $request->processor_price - $request->aggregator_price,
            'status_id' => 8,
            'created_at' => $request->date,
            'created_by' => Auth::id()
        );
        try {
            $result = DB::table('delivery')->insert($data);
            $dispatch = array('status_id' => 5);
            DB::table('dispatch')->where('id', $request->dispatch)->update($dispatch);
            return $result;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            throw new HttpResponseException(response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']));
        }
    }

    public function warehouseCreate($request)
    {
        if (empty($request->date)) {
            $request->date = now();
        }
        $data = array(
            'warehouse_id' => $request->warehouse,
            'quantity' => $request->quantity,
            'aggregator_id' => $request->aggregator,
            'aggregator_price' => $request->aggregator_price,
            'partner_price' => $request->partner_price,
            'partner_id' => 1,
            'way_ticket_path' => 'upload/tickets/warehouse',
            'margin' => $request->partner_price - $request->aggregator_price,
            'created_at' => $request->date,
            'created_by' => Auth::id()
        );
        try {
            return DB::table('warehouse_delivery')->insert($data);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            throw new HttpResponseException(response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']));
        }
    }

    public function getAllDeliveries($request)
    {
        $deliveries = Delivery::join('dispatch', 'dispatch_id', '=', 'dispatch.id')
            ->join('trade', 'trade.id', '=', 'dispatch.trade_id')
            ->join('aggregator', 'aggregator.id', '=', 'dispatch.aggregator_id')
            ->join('partner', 'partner.id', '=', 'trade.partner_id')
            ->join('commodity', 'commodity.id', '=', 'dispatch.commodity_id')
            ->join('status', 'status.id', '=', 'delivery.status_id');

        if (!is_null($request['code'])) {
            $deliveries->where('dispatch.code', '=', $request['code']);
        }
        if (!is_null($request['truck_number'])) {
            $deliveries->where('dispatch.truck_number', '=', $request['truck_number']);
        }
        if (!is_null($request['partner_id'])) {
            $deliveries->where('delivery.partner_id', '=', $request['partner_id']);
        }
        if (!is_null($request['start_date']) && !is_null($request['end_date'])) {
            $startDate = $request['start_date'] . ' 00:00:00';
            $endDate   = $request['end_date'] . ' 23:59:59';
            $deliveries->whereBetween('delivery.created_at', array($startDate, $endDate));
        }
        $deliveries->orderBy('delivery.created_at', 'desc');
        $deliveries->select(
            'delivery.*',
            'dispatch.truck_number',
            'partner.name As partner',
            'status.name As status',
            'dispatch.code',
            'aggregator.name As aggregator',
            'commodity.name As commodity'
        );
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

    public function getAllWarehouseDeliveries($request)
    {
        $deliveries = Delivery::join('dispatch', 'dispatch_id', '=', 'dispatch.id')
            ->join('trade', 'trade.id', '=', 'dispatch.trade_id')
            ->join('aggregator', 'aggregator.id', '=', 'dispatch.aggregator_id')
            ->join('partner', 'partner.id', '=', 'trade.partner_id')
            ->join('commodity', 'commodity.id', '=', 'dispatch.commodity_id')
            ->join('status', 'status.id', '=', 'delivery.status_id');

        if (!is_null($request['code'])) {
            $deliveries->where('dispatch.code', '=', $request['code']);
        }
        if (!is_null($request['truck_number'])) {
            $deliveries->where('dispatch.truck_number', '=', $request['truck_number']);
        }
        if (!is_null($request['partner_id'])) {
            $deliveries->where('delivery.partner_id', '=', $request['partner_id']);
        }
        if (!is_null($request['start_date']) && !is_null($request['end_date'])) {
            $startDate = $request['start_date'] . ' 00:00:00';
            $endDate   = $request['end_date'] . ' 23:59:59';
            $deliveries->whereBetween('delivery.created_at', array($startDate, $endDate));
        }
        $deliveries->orderBy('delivery.created_at', 'desc');
        $deliveries->select(
            'delivery.*',
            'dispatch.truck_number',
            'partner.name As partner',
            'status.name As status',
            'dispatch.code',
            'aggregator.name As aggregator',
            'commodity.name As commodity'
        );
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
}
