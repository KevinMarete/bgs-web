<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\OrderItem;
use App\OrderLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('organization', 'order_items', 'order_items.organization', 'order_items.product_now.product', 'order_logs', 'order_logs.user')->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Order::$rules);
        $order = Order::firstOrCreate($request->all(), $request->all());
        return response()->json($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('organization', 'order_items', 'order_items.organization', 'order_items.product_now.product', 'order_logs', 'order_logs.user')->find($id);
        if(is_null($order)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($order);
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
        $this->validate($request, Order::$rules);
        $order  = Order::find($id);
        if(is_null($order)){
            return response()->json(['error' => 'not_found']);
        }
        $order->update($request->all());
        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if(is_null($order)){
            return response()->json(['error' => 'not_found']);
        }
        $order->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display the specified Order's Items.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrderItems($id)
    {
        $orderitems = OrderItem::with('order', 'organization', 'product_now')->where('order_id', $id)->get();
        return response()->json($orderitems);
    }

    /**
     * Display the specified Order's Logs.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrderLogs($id)
    {
        $orderlogs = OrderLog::with('order', 'organization', 'user')->where('order_id', $id)->get();
        return response()->json($orderlogs);
    }
}
