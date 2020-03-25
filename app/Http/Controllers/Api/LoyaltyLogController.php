<?php

namespace App\Http\Controllers\Api;

use App\LoyaltyLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoyaltyLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loyaltylogs = LoyaltyLog::with('organization')->get();
        return response()->json($loyaltylogs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, LoyaltyLog::$rules);
        $loyaltylog = LoyaltyLog::firstOrCreate($request->all(), $request->all());
        return response()->json($loyaltylog);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loyaltylog = LoyaltyLog::with('organization')->find($id);
        if(is_null($loyaltylog)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($loyaltylog);
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
        $this->validate($request, LoyaltyLog::$rules);
        $loyaltylog  = LoyaltyLog::find($id);
        if(is_null($loyaltylog)){
            return response()->json(['error' => 'not_found']);
        }
        $loyaltylog->update($request->all());
        return response()->json($loyaltylog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loyaltylog = LoyaltyLog::find($id);
        if(is_null($loyaltylog)){
            return response()->json(['error' => 'not_found']);
        }
        $loyaltylog->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
