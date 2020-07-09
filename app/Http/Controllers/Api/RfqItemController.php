<?php

namespace App\Http\Controllers\Api;

use App\RfqItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RfqItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rfqitems = RfqItem::with('product_now', 'organization', 'rfq')->get();
        return response()->json($rfqitems);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, RfqItem::$rules);
        $rfqitem = RfqItem::firstOrCreate($request->all(), $request->all());
        return response()->json($rfqitem);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rfqitem = RfqItem::with('product_now', 'organization', 'rfq')->find($id);
        if (is_null($rfqitem)) {
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($rfqitem);
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
        $this->validate($request, RfqItem::$rules);
        $rfqitem  = RfqItem::find($id);
        if (is_null($rfqitem)) {
            return response()->json(['error' => 'not_found']);
        }
        $rfqitem->update($request->all());
        return response()->json($rfqitem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rfqitem = RfqItem::find($id);
        if (is_null($rfqitem)) {
            return response()->json(['error' => 'not_found']);
        }
        $rfqitem->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
