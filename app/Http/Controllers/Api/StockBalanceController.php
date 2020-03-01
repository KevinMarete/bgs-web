<?php

namespace App\Http\Controllers\Api;

use App\StockBalance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stockbalances = StockBalance::with('product', 'organization')->get();
        return response()->json($stockbalances);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, StockBalance::$rules);
        $stockbalance = StockBalance::firstOrCreate($request->all(), $request->all());
        return response()->json($stockbalance);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stockbalance = StockBalance::with('product', 'organization')->find($id);
        if(is_null($stockbalance)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($stockbalance);
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
        $this->validate($request, StockBalance::$rules);
        $stockbalance  = StockBalance::find($id);
        if(is_null($stockbalance)){
            return response()->json(['error' => 'not_found']);
        }
        $stockbalance->update($request->all());
        return response()->json($stockbalance);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stockbalance = StockBalance::find($id);
        if(is_null($stockbalance)){
            return response()->json(['error' => 'not_found']);
        }
        $stockbalance->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
