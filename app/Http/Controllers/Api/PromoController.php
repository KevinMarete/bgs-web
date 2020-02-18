<?php

namespace App\Http\Controllers\Api;

use App\Promo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promos = Promo::all();
        return response()->json($promos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Promo::$rules);
        $promo = Promo::firstOrCreate($request->all(), $request->all());
        return response()->json($promo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promo = Promo::find($id);
        if(is_null($promo)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($promo);
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
        $this->validate($request, Promo::$rules);
        $promo  = Promo::find($id);
        if(is_null($promo)){
            return response()->json(['error' => 'not_found']);
        }
        $promo->update($request->all());
        return response()->json($promo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promo = Promo::find($id);
        if(is_null($promo)){
            return response()->json(['error' => 'not_found']);
        }
        $promo->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
