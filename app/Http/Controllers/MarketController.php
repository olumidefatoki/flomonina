<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMarketRequest;
use App\Models\Market;
use App\Models\State;
use App\Services\MarketService;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('market.index', ['states' => State::all()]);
    }

    public function getMarketList(Request $request,MarketService $service)
    {
        return $service->getAllMarkets($request);
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
    public function store(CreateMarketRequest $request, MarketService $service)
    {
        $result = $service->create($request);
        if ($result) {
            return response()->json(['status' => 1, 'msg' => 'New Market has been successfully created.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Market  $market 
     * @return \Illuminate\Http\Response
     */
    public function show(Market $market)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function edit(Market $market)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Market $market)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function destroy(Market $market)
    {
        //
    }
}
