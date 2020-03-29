<?php

namespace App\Http\Controllers\Api;

use App\Payout;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payouts = Payout::with('order', 'organization')->get();
        return response()->json($payouts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Payout::$rules);
        $payout = Payout::firstOrCreate($request->all(), $request->all());
        return response()->json($payout);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payout = Payout::with('order', 'organization')->find($id);
        if(is_null($payout)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($payout);
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
        $this->validate($request, Payout::$rules);
        $payout  = Payout::find($id);
        if(is_null($payout)){
            return response()->json(['error' => 'not_found']);
        }
        $payout->update($request->all());
        return response()->json($payout);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payout = Payout::find($id);
        if(is_null($payout)){
            return response()->json(['error' => 'not_found']);
        }
        $payout->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
