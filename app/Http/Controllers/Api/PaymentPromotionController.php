<?php

namespace App\Http\Controllers\Api;

use App\PaymentPromotion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentPromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentpromotions = PaymentPromotion::with('payment', 'promotion', 'promotion.product_now', 'promotion.product_now.product')->get();
        return response()->json($paymentpromotions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, PaymentPromotion::$rules);
        $paymentpromotion = PaymentPromotion::firstOrCreate($request->all(), $request->all());
        return response()->json($paymentpromotion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentpromotion = PaymentPromotion::with('payment', 'promotion', 'promotion.product_now', 'promotion.product_now.product')->find($id);
        if (is_null($paymentpromotion)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($paymentpromotion);
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
        $this->validate($request, PaymentPromotion::$rules);
        $paymentpromotion  = PaymentPromotion::find($id);
        if (is_null($paymentpromotion)) {
            return response()->json(['error' => 'not_found']);
        }
        $paymentpromotion->update($request->all());
        return response()->json($paymentpromotion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentpromotion = PaymentPromotion::find($id);
        if (is_null($paymentpromotion)) {
            return response()->json(['error' => 'not_found']);
        }
        $paymentpromotion->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
