<?php

namespace App\Http\Controllers\Api;

use App\CreditLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $creditlogs = CreditLog::with('credit')->get();
        return response()->json($creditlogs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, CreditLog::$rules);
        $creditlog = CreditLog::create($request->all());
        return response()->json($creditlog);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $creditlog = CreditLog::with('credit')->find($id);
        if(is_null($creditlog)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($creditlog);
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
        $this->validate($request, CreditLog::$rules);
        $creditlog  = CreditLog::find($id);
        if(is_null($creditlog)){
            return response()->json(['error' => 'not_found']);
        }
        $creditlog->update($request->all());
        return response()->json($creditlog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $creditlog = CreditLog::find($id);
        if(is_null($creditlog)){
            return response()->json(['error' => 'not_found']);
        }
        $creditlog->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
