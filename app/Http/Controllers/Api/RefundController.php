<?php

namespace App\Http\Controllers\Api;

use App\Refund;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $refunds = Refund::with('order')->get();
        return response()->json($refunds);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Refund::$rules);
        $refund = Refund::firstOrCreate($request->all(), $request->all());
        return response()->json($refund);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $refund = Refund::with('order')->find($id);
        if(is_null($refund)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($refund);
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
        $this->validate($request, Refund::$rules);
        $refund  = Refund::find($id);
        if(is_null($refund)){
            return response()->json(['error' => 'not_found']);
        }
        $refund->update($request->all());
        return response()->json($refund);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $refund = Refund::find($id);
        if(is_null($refund)){
            return response()->json(['error' => 'not_found']);
        }
        $refund->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
