<?php

namespace App\Http\Controllers\Api;

use App\Credit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $credits = Credit::with('user')->get();
        return response()->json($credits);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Credit::$rules);
        $credit = Credit::updateOrCreate([
            'user_id' => $request->user_id
        ], $request->all());
        return response()->json($credit);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $credit = Credit::with('user')->find($id);
        if(is_null($credit)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($credit);
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
        $this->validate($request, Credit::$rules);
        $credit  = Credit::find($id);
        if(is_null($credit)){
            return response()->json(['error' => 'not_found']);
        }
        $credit->update($request->all());
        return response()->json($credit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $credit = Credit::find($id);
        if(is_null($credit)){
            return response()->json(['error' => 'not_found']);
        }
        $credit->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
