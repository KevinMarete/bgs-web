<?php

namespace App\Http\Controllers\Api;

use App\CreditLog;
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
        if (is_null($order)) {
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
        if (is_null($order)) {
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
        if (is_null($order)) {
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

    /**
     * Display the specified Order's CreditLog.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCreditLog($id)
    {
        $orderlogs = CreditLog::with('credit', 'credit.user')->where('status', 'used_on_order_#' . $id)->first();
        return response()->json($orderlogs);
    }

    /**
     * Display Count of all Orders by Status based on updated_date
     * @return \Illuminate\Http\Response
     */
    public function getOrdersByStatus(Request $request)
    {
        $orders = Order::where('status', $request->status)->whereDate('updated_at', $request->updated_at)->get();
        return response()->json(['status' => $request->status, 'total' => sizeof($orders)]);
    }

    /**
     * Display Revenue based on orders by created_date
     * @param  date  $created_date
     * @return \Illuminate\Http\Response
     */
    public function getOrderRevenue($created_date)
    {
        $revenue = Order::whereNotIn('status', ['cancelled, awaiting_refund', 'refunded, order_cancelled'])->whereDate('created_at', $created_date)
            ->selectRaw('sum(product_total + shipping_total) as revenue')->first();
        return response()->json($revenue);
    }
}
