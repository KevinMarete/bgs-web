<?php

namespace App\Http\Controllers\Api;

use App\PaymentDeal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentDealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentdeals = PaymentDeal::with('payment', 'product_deal', 'product_deal.product_now', 'product_deal.deal', 'product_deal.product_now.product')->get();
        return response()->json($paymentdeals);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, PaymentDeal::$rules);
        $paymentdeal = PaymentDeal::firstOrCreate($request->all(), $request->all());
        return response()->json($paymentdeal);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentdeal = PaymentDeal::with('payment', 'product_deal', 'product_deal.product_now', 'product_deal.deal', 'product_deal.product_now.product')->find($id);
        if(is_null($paymentdeal)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($paymentdeal);
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
        $this->validate($request, PaymentDeal::$rules);
        $paymentdeal  = PaymentDeal::find($id);
        if(is_null($paymentdeal)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentdeal->update($request->all());
        return response()->json($paymentdeal);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentdeal = PaymentDeal::find($id);
        if(is_null($paymentdeal)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentdeal->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
