<?php

namespace App\Http\Controllers\Api;

use App\HowTo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HowToController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $how_tos = HowTo::all();
        return response()->json($how_tos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, HowTo::$rules);
        $how_to = HowTo::firstOrCreate($request->all(), $request->all());
        return response()->json($how_to);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $how_to = HowTo::find($id);
        if (is_null($how_to)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($how_to);
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
        $this->validate($request, HowTo::$rules);
        $how_to  = HowTo::find($id);
        if (is_null($how_to)) {
            return response()->json(['error' => 'not_found']);
        }
        $how_to->update($request->all());
        return response()->json($how_to);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $how_to = HowTo::find($id);
        if (is_null($how_to)) {
            return response()->json(['error' => 'not_found']);
        }
        $how_to->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
