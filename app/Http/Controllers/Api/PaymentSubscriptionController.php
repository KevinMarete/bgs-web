<?php

namespace App\Http\Controllers\Api;

use App\PaymentSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentsubscriptions = PaymentSubscription::with('payment', 'subscription')->get();
        return response()->json($paymentsubscriptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, PaymentSubscription::$rules);
        $paymentsubscription = PaymentSubscription::firstOrCreate($request->all(), $request->all());
        return response()->json($paymentsubscription);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentsubscription = PaymentSubscription::with('payment', 'subscription')->find($id);
        if(is_null($paymentsubscription)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($paymentsubscription);
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
        $this->validate($request, PaymentSubscription::$rules);
        $paymentsubscription  = PaymentSubscription::find($id);
        if(is_null($paymentsubscription)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentsubscription->update($request->all());
        return response()->json($paymentsubscription);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentsubscription = PaymentSubscription::find($id);
        if(is_null($paymentsubscription)){
            return response()->json(['error' => 'not_found']);
        }
        $paymentsubscription->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
