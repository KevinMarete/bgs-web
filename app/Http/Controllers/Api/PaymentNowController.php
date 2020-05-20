<?php

namespace App\Http\Controllers\Api;

use App\PaymentNow;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentNowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentnows = PaymentNow::with('payment', 'product_now', 'product_now.product')->get();
        return response()->json($paymentnows);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, PaymentNow::$rules);
        $paymentnow = PaymentNow::firstOrCreate($request->all(), $request->all());
        return response()->json($paymentnow);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentnow = PaymentNow::with('payment', 'product_now', 'product_now.product')->find($id);
        if(is_null($paymentnow)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($paymentnow);
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
        $this->validate($request, PaymentNow::$rules);
        $paymentnow  = PaymentNow::find($id);
        if(is_null($paymentnow)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentnow->update($request->all());
        return response()->json($paymentnow);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentnow = PaymentNow::find($id);
        if(is_null($paymentnow)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentnow->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
