<?php

namespace App\Http\Controllers\Api;

use App\StockType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocktypes = StockType::all();
        return response()->json($stocktypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, StockType::$rules);
        $stocktype = StockType::firstOrCreate($request->all(), $request->all());
        return response()->json($stocktype);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stocktype = StockType::find($id);
        if(is_null($stocktype)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($stocktype);
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
        $this->validate($request, StockType::$rules);
        $stocktype  = StockType::find($id);
        if(is_null($stocktype)){
            return response()->json(['error' => 'not_found']);
        }
        $stocktype->update($request->all());
        return response()->json($stocktype);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stocktype = StockType::find($id);
        if(is_null($stocktype)){
            return response()->json(['error' => 'not_found']);
        }
        $stocktype->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}