<?php

namespace App\Http\Controllers\Api;

use App\Deal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deals = Deal::all();
        return response()->json($deals);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Deal::$rules);
        $deal = Deal::firstOrCreate($request->all(), $request->all());
        return response()->json($deal);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deal = Deal::find($id);
        if(is_null($deal)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($deal);
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
        $this->validate($request, Deal::$rules);
        $deal  = Deal::find($id);
        if(is_null($deal)){
            return response()->json(['error' => 'not_found']);
        }
        $deal->update($request->all());
        return response()->json($deal);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deal = Deal::find($id);
        if(is_null($deal)){
            return response()->json(['error' => 'not_found']);
        }
        $deal->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
