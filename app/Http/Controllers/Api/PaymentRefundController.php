<?php

namespace App\Http\Controllers\Api;

use App\PaymentRefund;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentRefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentrefunds = PaymentRefund::with('payment', 'refund')->get();
        return response()->json($paymentrefunds);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, PaymentRefund::$rules);
        $paymentrefund = PaymentRefund::firstOrCreate($request->all(), $request->all());
        return response()->json($paymentrefund);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentrefund = PaymentRefund::with('payment', 'refund')->find($id);
        if(is_null($paymentrefund)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($paymentrefund);
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
        $this->validate($request, PaymentRefund::$rules);
        $paymentrefund  = PaymentRefund::find($id);
        if(is_null($paymentrefund)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentrefund->update($request->all());
        return response()->json($paymentrefund);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentrefund = PaymentRefund::find($id);
        if(is_null($paymentrefund)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentrefund->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
