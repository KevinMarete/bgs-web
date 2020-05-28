<?php

namespace App\Http\Controllers\Api;

use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('product_category', 'organization')->orderBy('molecular_name', 'ASC')->get();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Product::$rules);
        $product = Product::firstOrCreate([
            'molecular_name' => $request->molecular_name,
            'brand_name' => $request->brand_name,
            'pack_size' => $request->pack_size,
            'strength' => $request->strength,
            'product_category_id' => $request->product_category_id,
            'organization_id' => $request->organization_id,
        ], $request->all());
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('product_category', 'organization')->find($id);
        if (is_null($product)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($product);
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
        $this->validate($request, Product::$rules);
        $product  = Product::find($id);
        if (is_null($product)) {
            return response()->json(['error' => 'not_found']);
        }
        $product->update($request->all());
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json(['error' => 'not_found']);
        }
        $product->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
