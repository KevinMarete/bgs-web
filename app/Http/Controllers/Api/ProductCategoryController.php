<?php

namespace App\Http\Controllers\Api;

use App\ProductCategory;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productcategories = ProductCategory::all();
        return response()->json($productcategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ProductCategory::$rules);
        $productcategory = ProductCategory::firstOrCreate([
            'name' => $request->name
        ], $request->all());
        return response()->json($productcategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productcategory = ProductCategory::find($id);
        if(is_null($productcategory)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($productcategory);
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
        $this->validate($request, ProductCategory::$rules);
        $productcategory  = ProductCategory::find($id);
        if(is_null($productcategory)){
            return response()->json(['error' => 'not_found']);
        }
        $productcategory->update($request->all());
        return response()->json($productcategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productcategory = ProductCategory::find($id);
        if(is_null($productcategory)){
            return response()->json(['error' => 'not_found']);
        }
        $productcategory->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display the specified ProductCategory's products.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCategoryProducts($id)
    {
        $products = Product::with('productcategory')->where('product_category_id', $id)->get();
        return response()->json($products);
    }
}
