<?php

namespace App\Http\Controllers\Api;

use App\PaymentOffer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentoffers = PaymentOffer::with('payment', 'offer', 'offer.product_now', 'offer.product_now.product')->get();
        return response()->json($paymentoffers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, PaymentOffer::$rules);
        $paymentoffer = PaymentOffer::firstOrCreate($request->all(), $request->all());
        return response()->json($paymentoffer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentoffer = PaymentOffer::with('payment', 'offer', 'offer.product_now', 'offer.product_now.product')->find($id);
        if (is_null($paymentoffer)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($paymentoffer);
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
        $this->validate($request, PaymentOffer::$rules);
        $paymentoffer  = PaymentOffer::find($id);
        if (is_null($paymentoffer)) {
            return response()->json(['error' => 'not_found']);
        }
        $paymentoffer->update($request->all());
        return response()->json($paymentoffer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentoffer = PaymentOffer::find($id);
        if (is_null($paymentoffer)) {
            return response()->json(['error' => 'not_found']);
        }
        $paymentoffer->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
