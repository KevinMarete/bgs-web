<?php

namespace App\Http\Controllers\Api;

use App\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscription::all();
        return response()->json($subscriptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Subscription::$rules);
        $subscription = Subscription::create($request->all());
        return response()->json($subscription);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subscription = Subscription::find($id);
        if(is_null($subscription)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($subscription);
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
        $this->validate($request, Subscription::$rules);
        $subscription  = Subscription::find($id);
        if(is_null($subscription)){
            return response()->json(['error' => 'not_found']);
        }
        $subscription->update($request->all());
        return response()->json($subscription);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscription = Subscription::find($id);
        if(is_null($subscription)){
            return response()->json(['error' => 'not_found']);
        }
        $subscription->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
