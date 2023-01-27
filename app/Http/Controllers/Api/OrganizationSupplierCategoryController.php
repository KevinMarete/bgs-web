<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\OrganizationSupplierCategory;
use Illuminate\Http\Request;

class OrganizationSupplierCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organization_supplier_categories = OrganizationSupplierCategory::with('organization', 'supplier_category')->get();
        return response()->json($organization_supplier_categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, OrganizationSupplierCategory::$rules);
        $organization_supplier_category = OrganizationSupplierCategory::firstOrCreate([
            'organization_id' => $request->organization_id,
            'supplier_category_id' => $request->supplier_category_id
        ], $request->all());
        return response()->json($organization_supplier_category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organization_supplier_category = OrganizationSupplierCategory::find($id);
        if (is_null($organization_supplier_category)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($organization_supplier_category);
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
        $this->validate($request, OrganizationSupplierCategory::$rules);
        $organization_supplier_category  = OrganizationSupplierCategory::find($id);
        if (is_null($organization_supplier_category)) {
            return response()->json(['error' => 'not_found']);
        }
        $organization_supplier_category->update($request->all());
        return response()->json($organization_supplier_category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization_supplier_category = OrganizationSupplierCategory::find($id);
        if (is_null($organization_supplier_category)) {
            return response()->json(['error' => 'not_found']);
        }
        $organization_supplier_category->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
