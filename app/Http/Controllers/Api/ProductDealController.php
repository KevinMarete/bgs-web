<?php

namespace App\Http\Controllers\Api;

use App\ProductDeal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductDealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productdeals = ProductDeal::with('product_now', 'offer')->get();
        return response()->json($productdeals);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ProductDeal::$rules);
        $productdeal = ProductDeal::firstOrCreate($request->all(), $request->all());
        return response()->json($productdeal);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productdeal = ProductDeal::with('product_now', 'offer')->find($id);
        if(is_null($productdeal)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($productdeal);
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
        $this->validate($request, ProductDeal::$rules);
        $productdeal  = ProductDeal::find($id);
        if(is_null($productdeal)){
            return response()->json(['error' => 'not_found']);
        }
        $productdeal->update($request->all());
        return response()->json($productdeal);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productdeal = ProductDeal::find($id);
        if(is_null($productdeal)){
            return response()->json(['error' => 'not_found']);
        }
        $productdeal->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
