<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\Warehouse;
use App\Models\Aggregator;
use Illuminate\Http\Request;
use App\Services\DeliveryService;
use App\Services\InventoryService;
use App\Http\Requests\CreatePurcharseRequest;

class InventoryController extends Controller
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
    }

    public function purcharseIndex()
    {
        return view(
            'inventory.purchase.index',
            [
                'warehouses' => Warehouse::where('type','FLOMUVINA')->get(),
                'commodities' => Commodity::all(),
            ]
        );
    }

    public function supplyIndex()
    {
        return view('inventory.supply.index');
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
    public function purcharseStore(CreatePurcharseRequest $request, InventoryService $service)
    {
        $service->createPurcharse($request);
    }
    public function supplyStore(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
