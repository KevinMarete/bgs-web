<?php

namespace App\Http\Controllers\Api;

use App\OrderLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderlogs = OrderLog::with('user', 'organization', 'order')->get();
        return response()->json($orderlogs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, OrderLog::$rules);
        $orderlog = OrderLog::firstOrCreate($request->all(), $request->all());
        return response()->json($orderlog);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderlog = OrderLog::with('user', 'organization', 'order')->find($id);
        if(is_null($orderlog)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($orderlog);
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
        $this->validate($request, OrderLog::$rules);
        $orderlog  = OrderLog::find($id);
        if(is_null($orderlog)){
            return response()->json(['error' => 'not_found']);
        }
        $orderlog->update($request->all());
        return response()->json($orderlog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderlog = OrderLog::find($id);
        if(is_null($orderlog)){
            return response()->json(['error' => 'not_found']);
        }
        $orderlog->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
