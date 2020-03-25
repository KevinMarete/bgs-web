<?php

namespace App\Http\Controllers\Api;

use App\OrderItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderitems = OrderItem::with('product_now', 'organization', 'order')->get();
        return response()->json($orderitems);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, OrderItem::$rules);
        $orderitem = OrderItem::firstOrCreate($request->all(), $request->all());
        return response()->json($orderitem);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderitem = OrderItem::with('product_now', 'organization', 'order')->find($id);
        if(is_null($orderitem)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($orderitem);
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
        $this->validate($request, OrderItem::$rules);
        $orderitem  = OrderItem::find($id);
        if(is_null($orderitem)){
            return response()->json(['error' => 'not_found']);
        }
        $orderitem->update($request->all());
        return response()->json($orderitem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderitem = OrderItem::find($id);
        if(is_null($orderitem)){
            return response()->json(['error' => 'not_found']);
        }
        $orderitem->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
