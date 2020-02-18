<?php

namespace App\Http\Controllers\Api;

use App\OrganizationPaymentType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizationPaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organization_payment_types = OrganizationPaymentType::all();
        return response()->json($organization_payment_types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, OrganizationPaymentType::$rules);
        $organization_payment_type = OrganizationPaymentType::firstOrCreate([
            'organization_id' => $request->organization_id,
            'payment_type_id' => $request->payment_type_id
        ], $request->all());
        return response()->json($organization_payment_type);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organization_payment_type = OrganizationPaymentType::find($id);
        if(is_null($organization_payment_type)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($organization_payment_type);
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
        $this->validate($request, OrganizationPaymentType::$rules);
        $organization_payment_type  = OrganizationPaymentType::find($id);
        if(is_null($organization_payment_type)){
            return response()->json(['error' => 'not_found']);
        }
        $organization_payment_type->update($request->all());
        return response()->json($organization_payment_type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization_payment_type = OrganizationPaymentType::find($id);
        if(is_null($organization_payment_type)){
            return response()->json(['error' => 'not_found']);
        }
        $organization_payment_type->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}