<?php

namespace App\Http\Controllers\Api;

use App\RfqLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RfqLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rfqlogs = RfqLog::with('user', 'organization', 'rfq')->get();
        return response()->json($rfqlogs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, RfqLog::$rules);
        $rfqlog = RfqLog::firstOrCreate($request->all(), $request->all());
        return response()->json($rfqlog);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rfqlog = RfqLog::with('user', 'organization', 'rfq')->find($id);
        if (is_null($rfqlog)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($rfqlog);
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
        $this->validate($request, RfqLog::$rules);
        $rfqlog  = RfqLog::find($id);
        if (is_null($rfqlog)) {
            return response()->json(['error' => 'not_found']);
        }
        $rfqlog->update($request->all());
        return response()->json($rfqlog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rfqlog = RfqLog::find($id);
        if (is_null($rfqlog)) {
            return response()->json(['error' => 'not_found']);
        }
        $rfqlog->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
