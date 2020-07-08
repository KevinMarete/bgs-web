<?php

namespace App\Http\Controllers\Api;

use App\Offer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::with('product_now', 'product_now.product', 'product_now.product.product_category', 'organization', 'product_now.organization', 'product_now.user')->get();
        return response()->json($offers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Offer::$rules);
        $offer = Offer::firstOrCreate([
            'status' => $request->status,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'discount' => $request->discount,
            'min_order_quantity' => $request->min_order_quantity,
            'product_now_id' => $request->product_now_id,
            'organization_id' => $request->organization_id
        ], $request->all());
        return response()->json($offer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer = Offer::with('product_now', 'product_now.product', 'product_now.product.product_category', 'organization', 'product_now.organization', 'product_now.user')->find($id);
        if (is_null($offer)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($offer);
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
        $this->validate($request, Offer::$rules);
        $offer  = Offer::find($id);
        if (is_null($offer)) {
            return response()->json(['error' => 'not_found']);
        }
        $offer->update($request->all());
        return response()->json($offer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = Offer::find($id);
        if (is_null($offer)) {
            return response()->json(['error' => 'not_found']);
        }
        $offer->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display all offers based on specified_date
     *
     * @param  date  $created_period_datedate
     * @return \Illuminate\Http\Response
     */
    public function getOffersByDate($period_date)
    {
        $promos = Offer::with('product_now', 'product_now.product', 'organization', 'product_now.organization', 'product_now.user')->whereDate('valid_from', '<=', $period_date)->whereDate('valid_until', '>=', $period_date)->get();
        return response()->json($promos);
    }
}
