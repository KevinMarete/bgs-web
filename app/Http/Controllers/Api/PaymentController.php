<?php

namespace App\Http\Controllers\Api;

use App\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with('organization', 'user')->get();
        return response()->json($payments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Payment::$rules);
        $payment = Payment::firstOrCreate($request->all(), $request->all());
        return response()->json($payment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::with('organization', 'user')->find($id);
        if(is_null($payment)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($payment);
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
        $this->validate($request, Payment::$rules);
        $payment  = Payment::find($id);
        if(is_null($payment)){
            return response()->json(['error' => 'not_found']);
        }
        $payment->update($request->all());
        return response()->json($payment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);
        if(is_null($payment)){
            return response()->json(['error' => 'not_found']);
        }
        $payment->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
