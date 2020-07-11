<?php

namespace App\Http\Controllers\Api;

use App\RfqReject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RfqRejectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rfqrejects = RfqReject::with('rfq', 'reject_reason')->get();
        return response()->json($rfqrejects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, RfqReject::$rules);
        $rfqreject = RfqReject::firstOrCreate($request->all(), $request->all());
        return response()->json($rfqreject);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rfqreject = RfqReject::with('rfq', 'reject_reason')->find($id);
        if (is_null($rfqreject)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($rfqreject);
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
        $this->validate($request, RfqReject::$rules);
        $rfqreject  = RfqReject::find($id);
        if (is_null($rfqreject)) {
            return response()->json(['error' => 'not_found']);
        }
        $rfqreject->update($request->all());
        return response()->json($rfqreject);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rfqreject = RfqReject::find($id);
        if (is_null($rfqreject)) {
            return response()->json(['error' => 'not_found']);
        }
        $rfqreject->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
