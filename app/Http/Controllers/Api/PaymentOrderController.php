<?php

namespace App\Http\Controllers\Api;

use App\PaymentOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentorders = PaymentOrder::with('organization')->get();
        return response()->json($paymentorders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, PaymentOrder::$rules);
        $paymentorder = PaymentOrder::firstOrCreate($request->all(), $request->all());
        return response()->json($paymentorder);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentorder = PaymentOrder::with('organization')->find($id);
        if(is_null($paymentorder)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($paymentorder);
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
        $this->validate($request, PaymentOrder::$rules);
        $paymentorder  = PaymentOrder::find($id);
        if(is_null($paymentorder)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentorder->update($request->all());
        return response()->json($paymentorder);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentorder = PaymentOrder::find($id);
        if(is_null($paymentorder)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentorder->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
