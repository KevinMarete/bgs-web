<?php

namespace App\Http\Controllers\Api;

use App\ProductNow;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductNowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = 'ASC';
        $productnows = ProductNow::with(['product' => function ($q) use ($order) {
            $q->orderBy('molecular_name', $order);
        }, 'product.product_category', 'organization', 'user'])->orderBy('unit_price', $order)->get();

        return response()->json($productnows);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ProductNow::$rules);
        $productnow = ProductNow::firstOrCreate([
            'product_id' => $request->product_id,
            'organization_id' => $request->organization_id,
        ], $request->all());
        return response()->json($productnow);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productnow = ProductNow::with('product', 'product.product_category', 'organization', 'user')->find($id);
        if (is_null($productnow)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($productnow);
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
        $this->validate($request, ProductNow::$rules);
        $productnow  = ProductNow::find($id);
        if (is_null($productnow)) {
            return response()->json(['error' => 'not_found']);
        }
        $productnow->update($request->all());
        return response()->json($productnow);
    }

    /**
     * Update the specified resource in storage (patch method).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function patch(Request $request, $id)
    {
        $productnow  = ProductNow::find($id);
        if (is_null($productnow)) {
            return response()->json(['error' => 'not_found']);
        }
        $productnow->update($request->all());
        return response()->json($productnow);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productnow = ProductNow::find($id);
        if (is_null($productnow)) {
            return response()->json(['error' => 'not_found']);
        }
        $productnow->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display all published productnows
     *
     * @return \Illuminate\Http\Response
     */
    public function getPublishedProductNows()
    {
        $order = 'ASC';
        $published_productnows = ProductNow::with(['product' => function ($q) use ($order) {
            $q->orderBy('molecular_name', $order);
        }, 'product.product_category', 'organization', 'user'])
            ->where('is_published', true)
            ->orderBy('unit_price', $order)->get();

        return response()->json($published_productnows);
    }

    /**
     * Display all unpublished productnows
     *
     * @return \Illuminate\Http\Response
     */
    public function getUnPublishedProductNows()
    {
        $order = 'ASC';
        $unpublished_productnows = ProductNow::with(['product' => function ($q) use ($order) {
            $q->orderBy('molecular_name', $order);
        }, 'product.product_category', 'organization', 'user'])
            ->where('is_published', false)
            ->orderBy('unit_price', $order)->get();

        return response()->json($unpublished_productnows);
    }
}
