<?php

namespace App\Services;

use Exception;
use DataTables;
use App\Models\CodeGen;
use App\Models\Partner;
use App\Models\Delivery;
use App\Models\Dispatch;
use App\Models\WarehouseDelivery;
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

        $file = $request->file('way_ticket');
        $path = 'upload/tickets/food_processor';
        if (!empty($file)) {
            $file_name = $trade->partner . '_' . $trade->aggregator . '_' . date('YmdHis') .  '.' . $file->extension();
            $upload = $file->move($path, $file_name);
        } else {
            $upload =  $path;
        }


        if (empty($request->date)) {
            $request->date = now();
        }

        $data = array(
            'dispatch_id' => $request->dispatch,
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

        $codeGen = CodeGen::find(2);
        $code = $codeGen->prefix . '/' .  $codeGen->next_num;
        $data = array('next_num' => sprintf('%06d', $codeGen->next_num + 1));
        DB::table('code_gen')->where('id', 2)->update($data);

        if (empty($request->date)) {
            $request->date = now();
        }
        $data = array(
            'commodity_id' => $request->commodity,
            'ticket_number' => $request->ticket_number,
            'code' => $code,
            'warehouse_id' => $request->warehouse,
            'quantity' => $request->quantity,
            'aggregator_id' => $request->aggregator,
            'aggregator_price' => $request->aggregator_price,
            'partner_price' => $request->partner_price,
            'truck_number' => $request->truck_number,
            'number_of_bags' => $request->number_of_bags,
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
        $deliveries->orderBy('delivery.uploaded_at', 'desc');
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
                return date('Y-m-d', strtotime($item->created_at));
            })
            ->make(true);
    }

    public function update($request)
    {
        
        $trade = Dispatch::join('trade', 'trade_id', '=', 'trade.id')
        ->join('aggregator', 'dispatch.aggregator_id', '=', 'aggregator.id')
        ->join('partner', 'trade.partner_id', '=', 'partner.id')
        ->join('delivery', 'delivery.dispatch_id', '=', 'dispatch.id')
        ->where('delivery.id', '=', $request->id)
        ->get(['aggregator.name As aggregator', 'partner.name As partner'])
        ->first();
        
        $file = $request->file('way_ticket');
        $path = 'upload/tickets/food_processor';
        if (!empty($file)) {
            $file_name = $trade->partner . '_' . $trade->aggregator . '_' . date('YmdHis') .  '.' . $file->extension();
            $upload = $file->move($path, $file_name);
        } else {
            $upload =  $path;
        }

        $data = array(
            'accepted_quantity' => $request->accepted_quantity,
            'aggregator_price' => $request->aggregator_price,
            'discounted_price' => $request->discounted_price,
            'trade_price' => $request->processor_price,
            'processor' => Partner::find($request->processor)->name,
            'partner_id' => $request->processor,
            'way_ticket' => $upload,
            'margin' => $request->processor_price - $request->aggregator_price,
            'updated_at' => now(),
            'created_by' => Auth::id()
        );
        try {
            $return = DB::table('delivery')->where('id', $request->id)->update($data);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            throw new HttpResponseException(response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']));
        }
    }

    public function getAllWarehouseDeliveries($request)
    {
        $deliveries = WarehouseDelivery::join('warehouse', 'warehouse.id', '=', 'warehouse_delivery.warehouse_id')
            ->join('state',  'state.id', '=', 'warehouse.state_id')
            ->join('partner',  'partner.id', '=', 'warehouse_delivery.partner_id')
            ->join('aggregator', 'aggregator.id', '=', 'warehouse_delivery.aggregator_id')
            ->join('commodity', 'commodity.id', '=', 'warehouse_delivery.commodity_id')
            ->join('users', 'users.id', '=', 'warehouse_delivery.created_by');


        if (!is_null($request['commodity_id'])) {
            $deliveries->where('warehouse_delivery.commodity_id', '=', $request['commodity_id']);
        }
        if (!is_null($request['aggregator_id'])) {
            $deliveries->where('warehouse_delivery.aggregator_id', '=', $request['aggregator_id']);
        }
        if (!is_null($request['code'])) {
            $deliveries->where('warehouse_delivery.code', '=', $request['code']);
        }
        if (!is_null($request['truck_number'])) {
            $deliveries->where('warehouse_delivery.truck_number', '=', $request['truck_number']);
        }
        if (!is_null($request['start_date']) && !is_null($request['end_date'])) {
            $startDate = $request['start_date'] . ' 00:00:00';
            $endDate   = $request['end_date'] . ' 23:59:59';
            $deliveries->whereBetween('warehouse_delivery.created_at', array($startDate, $endDate));
        }
        $deliveries->orderBy('warehouse_delivery.uploaded_at', 'desc');
        $deliveries->select(
            'warehouse_delivery.*',
            'partner.name As partner',
            'aggregator.name As aggregator',
            'commodity.name As commodity',
            'state.name As state',
            'warehouse.name As warehouse'
        );
        return DataTables::of($deliveries)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                                                <button class="btn btn-sm btn-info" data-id="' . $row['id'] . '" id="editWarehouseDeliveryBtn">Edit</button>  
                                          </div>';
            })->rawColumns(['actions'])
            ->editColumn('quantity', function ($item) {
                return number_format($item->quantity);
            })->editColumn('aggregator_amount', function ($item) {
                return number_format($item->aggregator_price * $item->accepted_quantity);
            })->editColumn('created_at', function ($item) {
                if (empty($item->created_at))
                    return $item->created_at;
                return date('Y-m-d H:i:s', strtotime($item->created_at));
            })
            ->make(true);
    }

    public function warehouseUpdate($request)
    {

        $data = array(
            'commodity_id' => $request->commodity,
            'warehouse_id' => $request->warehouse,
            'quantity' => $request->quantity,
            'aggregator_id' => $request->aggregator,
            'aggregator_price' => $request->aggregator_price,
            'partner_price' => $request->partner_price,
            'truck_number' => $request->truck_number,
            'number_of_bags' => $request->number_of_bags,
            'way_ticket_path' => 'upload/tickets/warehouse',
            'margin' => $request->partner_price - $request->aggregator_price,
        );
        try {
            return $return = DB::table('warehouse_delivery')->where('id', $request->id)->update($data);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            throw new HttpResponseException(response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']));
        }
    }
}
