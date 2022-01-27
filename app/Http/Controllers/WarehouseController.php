<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Http\Requests\CreateWarehouseRequest;
use App\Services\WarehouseService;
use Illuminate\Http\Request;

class WarehouseController extends Controller
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
    public function flomuvinaIndex()
    {
        return view('warehouse.flomuvina.index', ['states' => State::all()]);
    }
    public function thriveIndex()
    {
        return view('warehouse.thrive.index', ['states' => State::all()]);
    }

    public function getFlomuvinaWarehouses(Request $request, WarehouseService $service)
    {
        return  $service->getAllWarehouses($request, 'FLOMUVINA');
    }

    public function getThriveWarehouses(Request $request, WarehouseService $service)
    {
        return  $service->getAllWarehouses($request, 'THRIVE');
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
    public function storeFlomuvina(CreateWarehouseRequest $request, WarehouseService $service)
    {
        if ($service->create($request, 'FLOMUVINA'))
            return response()->json(['status' => 1, 'msg' => 'New Warehouse has been successfully created.']);
        response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']);
    }

    public function storeThrive(CreateWarehouseRequest $request, WarehouseService $service)
    {
        
        if ($service->create($request, 'THRIVE'))
            return response()->json(['status' => 1, 'msg' => 'New Warehouse has been successfully created.']);
        response()->json(['status' => 2, 'msg' => 'Something went wrong. Kindly contact the Admin.']);
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
