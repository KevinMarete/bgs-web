<?php

namespace App\Http\Controllers\Api;

use App\ProductPromo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductPromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = 'ASC';
        $productpromos = ProductPromo::with(['product_now.product' => function ($q) use ($order) {
            $q->orderBy('molecular_name', $order)->orderBy('unit_price', $order);
        }, 'offer', 'product_now', 'product_now.organization', 'product_now.user'])->get();

        return response()->json($productpromos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ProductPromo::$rules);
        $productpromo = ProductPromo::firstOrCreate($request->all(), $request->all());
        return response()->json($productpromo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productpromo = ProductPromo::with('product_now', 'offer', 'product_now.product')->find($id);
        if (is_null($productpromo)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($productpromo);
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
        $this->validate($request, ProductPromo::$rules);
        $productpromo  = ProductPromo::find($id);
        if (is_null($productpromo)) {
            return response()->json(['error' => 'not_found']);
        }
        $productpromo->update($request->all());
        return response()->json($productpromo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productpromo = ProductPromo::find($id);
        if (is_null($productpromo)) {
            return response()->json(['error' => 'not_found']);
        }
        $productpromo->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display all promos based on specified_date
     *
     * @param  date  $period_date
     * @return \Illuminate\Http\Response
     */
    public function getPromosByDate($period_date)
    {
        $promos = ProductPromo::with(['offer', 'product_now', 'product_now.product', 'product_now.organization'])->whereHas('offer', function ($query) use ($period_date) {
            $query->whereDate('valid_from', '<=', $period_date);
            $query->whereDate('valid_until', '>=', $period_date);
        })->get();
        return response()->json($promos);
    }
}
