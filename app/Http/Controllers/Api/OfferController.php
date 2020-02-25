<?php

namespace App\Http\Controllers\Api;

use App\Offer;
use App\Promo;
use App\Deal;
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
        $offers = Offer::with('organization')->get();
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
            'description' => $request->description,
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
        $offer = Offer::with('organization')->find($id);
        if(is_null($offer)){
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
        if(is_null($offer)){
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
        if(is_null($offer)){
            return response()->json(['error' => 'not_found']);
        }
        $offer->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display the specified Offer's promos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOfferPromos($id)
    {
        $promos = Promo::with('offer')->where('offer_id', $id)->get();
        return response()->json($promos);
    }

    /**
     * Display the specified Offer's deals.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOfferDeals($id)
    {
        $deals = Deal::with('offer')->where('offer_id', $id)->get();
        return response()->json($deals);
    }
}
