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
        $order = 'ASC';
        $productdeals = ProductDeal::with(['product_now.product' => function ($q) use ($order) {
            $q->orderBy('molecular_name', $order);
        }, 'product_now' => function ($q) use ($order) {
            $q->orderBy('unit_price', $order);
        }, 'offer', 'product_now.organization', 'product_now.user'])->get();
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
        $productdeal = ProductDeal::with('product_now', 'offer', 'product_now.product')->find($id);
        if (is_null($productdeal)) {
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
        if (is_null($productdeal)) {
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
        if (is_null($productdeal)) {
            return response()->json(['error' => 'not_found']);
        }
        $productdeal->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display all deals based on specified_date
     *
     * @param  date  $created_period_datedate
     * @return \Illuminate\Http\Response
     */
    public function getDealsByDate($period_date)
    {
        $promos = ProductDeal::with(['offer', 'product_now', 'product_now.product', 'product_now.organization'])->whereHas('offer', function ($query) use ($period_date) {
            $query->whereDate('valid_from', '<=', $period_date);
            $query->whereDate('valid_until', '>=', $period_date);
        })->get();
        return response()->json($promos);
    }
}
