<?php

namespace App\Http\Controllers\Api;

use App\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::all();
        return response()->json($stocks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Stock::$rules);
        $stock = Stock::firstOrCreate($request->all(), $request->all());
        return response()->json($stock);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stock = Stock::find($id);
        if(is_null($stock)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($stock);
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
        $this->validate($request, Stock::$rules);
        $stock  = Stock::find($id);
        if(is_null($stock)){
            return response()->json(['error' => 'not_found']);
        }
        $stock->update($request->all());
        return response()->json($stock);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = Stock::find($id);
        if(is_null($stock)){
            return response()->json(['error' => 'not_found']);
        }
        $stock->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
