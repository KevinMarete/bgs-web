<?php

namespace App\Http\Controllers\Api;

use App\PaymentType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_types = PaymentType::all();
        return response()->json($payment_types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, PaymentType::$rules);
        $payment_type = PaymentType::firstOrCreate([
            'name' => $request->name
        ], $request->all());
        return response()->json($payment_type);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment_type = PaymentType::find($id);
        if(is_null($payment_type)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($payment_type);
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
        $this->validate($request, PaymentType::$rules);
        $payment_type  = PaymentType::find($id);
        if(is_null($payment_type)){
            return response()->json(['error' => 'not_found']);
        }
        $payment_type->update($request->all());
        return response()->json($payment_type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment_type = PaymentType::find($id);
        if(is_null($payment_type)){
            return response()->json(['error' => 'not_found']);
        }
        $payment_type->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}