<?php

namespace App\Http\Controllers\Api;

use App\PaymentPromo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentPromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentpromos = PaymentPromo::with('payment', 'product_promo', 'product_promo.product_now', 'product_promo.promo', 'product_promo.product_now.product')->get();
        return response()->json($paymentpromos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, PaymentPromo::$rules);
        $paymentpromo = PaymentPromo::firstOrCreate($request->all(), $request->all());
        return response()->json($paymentpromo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentpromo = PaymentPromo::with('payment', 'product_promo', 'product_promo.product_now', 'product_promo.promo', 'product_promo.product_now.product')->find($id);
        if(is_null($paymentpromo)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($paymentpromo);
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
        $this->validate($request, PaymentPromo::$rules);
        $paymentpromo  = PaymentPromo::find($id);
        if(is_null($paymentpromo)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentpromo->update($request->all());
        return response()->json($paymentpromo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentpromo = PaymentPromo::find($id);
        if(is_null($paymentpromo)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentpromo->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
