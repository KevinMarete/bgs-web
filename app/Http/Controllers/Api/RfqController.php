<?php

namespace App\Http\Controllers\Api;

use App\Rfq;
use App\RfqItem;
use App\RfqLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RfqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rfqs = Rfq::with('organization', 'rfq_items', 'rfq_items.organization', 'rfq_items.product_now.product', 'rfq_logs', 'rfq_logs.user')->get();
        return response()->json($rfqs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Rfq::$rules);
        $rfq = Rfq::create($request->all(), $request->all());
        return response()->json($rfq);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rfq = Rfq::with('organization', 'organization.users', 'rfq_items', 'rfq_items.organization', 'rfq_items.organization.users', 'rfq_items.product_now.product', 'rfq_logs', 'rfq_logs.user', 'rfq_reject', 'rfq_reject.reject_reason')->find($id);
        if (is_null($rfq)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($rfq);
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
        $this->validate($request, Rfq::$rules);
        $rfq  = Rfq::find($id);
        if (is_null($rfq)) {
            return response()->json(['error' => 'not_found']);
        }
        $rfq->update($request->all());
        return response()->json($rfq);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rfq = Rfq::find($id);
        if (is_null($rfq)) {
            return response()->json(['error' => 'not_found']);
        }
        $rfq->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display the specified Rfq's Items.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getRfqItems($id)
    {
        $rfqitems = RfqItem::with('rfq', 'organization', 'product_now')->where('rfq_id', $id)->get();
        return response()->json($rfqitems);
    }

    /**
     * Display the specified Rfq's Logs.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getRfqLogs($id)
    {
        $rfqlogs = RfqLog::with('rfq', 'organization', 'user')->where('rfq_id', $id)->get();
        return response()->json($rfqlogs);
    }
}
