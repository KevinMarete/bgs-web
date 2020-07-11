<?php

namespace App\Http\Controllers\Api;

use App\PaymentRfq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentRfqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentrfqs = PaymentRfq::with('payment', 'rfq')->get();
        return response()->json($paymentrfqs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, PaymentRfq::$rules);
        $paymentrfq = PaymentRfq::firstOrCreate($request->all(), $request->all());
        return response()->json($paymentrfq);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentrfq = PaymentRfq::with('payment', 'rfq')->find($id);
        if (is_null($paymentrfq)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($paymentrfq);
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
        $this->validate($request, PaymentRfq::$rules);
        $paymentrfq  = PaymentRfq::find($id);
        if (is_null($paymentrfq)) {
            return response()->json(['error' => 'not_found']);
        }
        $paymentrfq->update($request->all());
        return response()->json($paymentrfq);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentrfq = PaymentRfq::find($id);
        if (is_null($paymentrfq)) {
            return response()->json(['error' => 'not_found']);
        }
        $paymentrfq->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
