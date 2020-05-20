<?php

namespace App\Http\Controllers\Api;

use App\PaymentPayout;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentPayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentpayouts = PaymentPayout::with('payment', 'payout')->get();
        return response()->json($paymentpayouts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, PaymentPayout::$rules);
        $paymentpayout = PaymentPayout::firstOrCreate($request->all(), $request->all());
        return response()->json($paymentpayout);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentpayout = PaymentPayout::with('payment', 'payout')->find($id);
        if(is_null($paymentpayout)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($paymentpayout);
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
        $this->validate($request, PaymentPayout::$rules);
        $paymentpayout  = PaymentPayout::find($id);
        if(is_null($paymentpayout)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentpayout->update($request->all());
        return response()->json($paymentpayout);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentpayout = PaymentPayout::find($id);
        if(is_null($paymentpayout)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentpayout->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
