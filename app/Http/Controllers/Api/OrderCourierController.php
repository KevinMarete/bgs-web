<?php

namespace App\Http\Controllers\Api;

use App\OrderCourier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderCourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordercouriers = OrderCourier::with('order', 'courier')->get();
        return response()->json($ordercouriers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, OrderCourier::$rules);
        $ordercourier = OrderCourier::firstOrCreate($request->all(), $request->all());
        return response()->json($ordercourier);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ordercourier = OrderCourier::with('order', 'courier')->find($id);
        if(is_null($ordercourier)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($ordercourier);
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
        $this->validate($request, OrderCourier::$rules);
        $ordercourier  = OrderCourier::find($id);
        if(is_null($ordercourier)){
            return response()->json(['error' => 'not_found']);
        }
        $ordercourier->update($request->all());
        return response()->json($ordercourier);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ordercourier = OrderCourier::find($id);
        if(is_null($ordercourier)){
            return response()->json(['error' => 'not_found']);
        }
        $ordercourier->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
