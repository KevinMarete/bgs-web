<?php

namespace App\Http\Controllers\Api;

use App\Courier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $couriers = Courier::all();
        return response()->json($couriers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Courier::$rules);
        $courier = Courier::firstOrCreate([
            'name' => $request->name,
            'email' => $request->email,
        ], $request->all());
        return response()->json($courier);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $courier = Courier::find($id);
        if(is_null($courier)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($courier);
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
        $this->validate($request, Courier::$rules);
        $courier  = Courier::find($id);
        if(is_null($courier)){
            return response()->json(['error' => 'not_found']);
        }
        $courier->update($request->all());
        return response()->json($courier);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courier = Courier::find($id);
        if(is_null($courier)){
            return response()->json(['error' => 'not_found']);
        }
        $courier->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
