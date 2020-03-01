<?php

namespace App\Http\Controllers\Api;

use App\Organization;
use App\Offer;
use App\OrganizationPaymentType;
use App\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizations = Organization::with('organization_type', 'organization_type.role')->get();
        return response()->json($organizations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, Organization::$rules);
        $organization = Organization::firstOrCreate([
            'name' => $request->name,
            'organization_type_id' => $request->organization_type_id
        ], $request->all());
        return response()->json($organization);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organization = Organization::with('organization_type', 'organization_type.role')->find($id);
        if(is_null($organization)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($organization);
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
        $this->validate($request, Organization::$rules);
        $organization  = Organization::find($id);
        if(is_null($organization)){
            return response()->json(['error' => 'not_found']);
        }
        $organization->update($request->all());
        return response()->json($organization);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);
        if(is_null($organization)){
            return response()->json(['error' => 'not_found']);
        }
        $organization->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display the specified Organization's offers.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrganizationOffers($id)
    {
        $offers = Offer::with('organization')->where('organization_id', $id)->get();
        return response()->json($offers);
    }

    /**
     * Display the specified Organization's PaymentTypes.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrganizationPaymentTypes($id)
    {
        $payment_types = OrganizationPaymentType::with('organization')->where('organization_id', $id)->get();
        return response()->json($payment_types);
    }

    /**
     * Display the specified Organization's Stocks.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrganizationStocks($id)
    {
        $stocks = Stock::with('organization', 'product', 'stock_type', 'user')->where('organization_id', $id)->get();
        return response()->json($stocks);
    }

    /**
     * Display the specified Organization's StockBalances.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrganizationStockBalances($id)
    {
        $stockbalances = Stock::with('organization', 'product')->where('organization_id', $id)->get();
        return response()->json($stockbalances);
    }
}
