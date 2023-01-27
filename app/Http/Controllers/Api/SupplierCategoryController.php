<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\OrganizationSupplierCategory;
use App\SupplierCategory;
use Illuminate\Http\Request;

class SupplierCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier_categories = SupplierCategory::all();
        return response()->json($supplier_categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, SupplierCategory::$rules);
        $supplier_category = SupplierCategory::firstOrCreate([
            'name' => $request->name
        ], $request->all());
        return response()->json($supplier_category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier_category = SupplierCategory::find($id);
        if (is_null($supplier_category)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($supplier_category);
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
        $this->validate($request, SupplierCategory::$rules);
        $supplier_category  = SupplierCategory::find($id);
        if (is_null($supplier_category)) {
            return response()->json(['error' => 'not_found']);
        }
        $supplier_category->update($request->all());
        return response()->json($supplier_category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier_category = SupplierCategory::find($id);
        if (is_null($supplier_category)) {
            return response()->json(['error' => 'not_found']);
        }
        $supplier_category->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display all organizations filtered by on $supplier_category_id
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getOrganizationsBySupplierCategory($id)
    {
        $organizations = OrganizationSupplierCategory::with('organization', 'supplier_category')
            ->where('supplier_category_id', $id)->get();
        return response()->json($organizations);
    }
}
