<?php

namespace App\Http\Controllers\Api;

use App\Package;
use App\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();
        return response()->json($packages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Package::$rules);
        $package = Package::firstOrCreate([
            'name' => $request->name
        ], $request->all());
        return response()->json($package);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $package = Package::find($id);
        if(is_null($package)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($package);
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
        $this->validate($request, Package::$rules);
        $package  = Package::find($id);
        if(is_null($package)){
            return response()->json(['error' => 'not_found']);
        }
        $package->update($request->all());
        return response()->json($package);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = Package::find($id);
        if(is_null($package)){
            return response()->json(['error' => 'not_found']);
        }
        $package->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display the specified package users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPackageUsers($id)
    {
        $users = Subscription::with('package', 'user')->where('package_id', $id)->get();
        return response()->json($users);
    }
}
