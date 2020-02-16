<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use App\Subscription;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, User::$rules);
        $user = User::firstOrCreate([
            'email' => $request->email,
            'organization_id' => $request->organization_id,
        ], $request->all());
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if(is_null($user)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($user);
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
        $this->validate($request, User::$rules);
        $user  = User::find($id);
        if(is_null($user)){
            return response()->json(['error' => 'not_found']);
        }
        $user->update($request->all());
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(is_null($user)){
            return response()->json(['error' => 'not_found']);
        }
        $user->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display the specified user's subscription.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUserSubscription($id)
    {
        $subscription = Subscription::with('user', 'package')->where('user_id', $id)->first();
        return response()->json($subscription);
    }
}
