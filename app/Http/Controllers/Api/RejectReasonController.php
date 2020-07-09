<?php

namespace App\Http\Controllers\Api;

use App\RejectReason;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RejectReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rejectreasons = RejectReason::all();
        return response()->json($rejectreasons);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, RejectReason::$rules);
        $rejectreason = RejectReason::firstOrCreate([
            'name' => $request->name
        ], $request->all());
        return response()->json($rejectreason);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rejectreason = RejectReason::find($id);
        if (is_null($rejectreason)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($rejectreason);
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
        $this->validate($request, RejectReason::$rules);
        $rejectreason  = RejectReason::find($id);
        if (is_null($rejectreason)) {
            return response()->json(['error' => 'not_found']);
        }
        $rejectreason->update($request->all());
        return response()->json($rejectreason);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rejectreason = RejectReason::find($id);
        if (is_null($rejectreason)) {
            return response()->json(['error' => 'not_found']);
        }
        $rejectreason->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
