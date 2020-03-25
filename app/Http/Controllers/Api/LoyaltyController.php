<?php

namespace App\Http\Controllers\Api;

use App\Loyalty;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoyaltyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loyalties = Loyalty::with('organization')->get();
        return response()->json($loyalties);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Loyalty::$rules);
        $loyalty = Loyalty::updateOrCreate([
            'user_id' => $request->user_id
        ], $request->all());
        return response()->json($loyalty);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loyalty = Loyalty::with('organization')->find($id);
        if(is_null($loyalty)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($loyalty);
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
        $this->validate($request, Loyalty::$rules);
        $loyalty  = Loyalty::find($id);
        if(is_null($loyalty)){
            return response()->json(['error' => 'not_found']);
        }
        $loyalty->update($request->all());
        return response()->json($loyalty);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loyalty = Loyalty::find($id);
        if(is_null($loyalty)){
            return response()->json(['error' => 'not_found']);
        }
        $loyalty->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
