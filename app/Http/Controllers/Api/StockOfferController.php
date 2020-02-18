<?php

namespace App\Http\Controllers\Api;

use App\StockOffer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stockoffers = StockOffer::all();
        return response()->json($stockoffers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, StockOffer::$rules);
        $stockoffer = StockOffer::firstOrCreate($request->all(), $request->all());
        return response()->json($stockoffer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stockoffer = StockOffer::find($id);
        if(is_null($stockoffer)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($stockoffer);
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
        $this->validate($request, StockOffer::$rules);
        $stockoffer  = StockOffer::find($id);
        if(is_null($stockoffer)){
            return response()->json(['error' => 'not_found']);
        }
        $stockoffer->update($request->all());
        return response()->json($stockoffer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stockoffer = StockOffer::find($id);
        if(is_null($stockoffer)){
            return response()->json(['error' => 'not_found']);
        }
        $stockoffer->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}