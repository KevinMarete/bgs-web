<?php

namespace App\Http\Controllers\Api;

use App\Organization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizations = Organization::all();
        return response()->json($organizations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, Organization::$rules);
        $organization = Organization::firstOrCreate([
            'name' => $request->name,
            'organization_type_id' => $request->organization_type_id
        ], $request->all());
        return response()->json($organization);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organization = Organization::find($id);
        if(is_null($organization)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($organization);
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
        $this->validate($request, Organization::$rules);
        $organization  = Organization::find($id);
        if(is_null($organization)){
            return response()->json(['error' => 'not_found']);
        }
        $organization->update($request->all());
        return response()->json($organization);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);
        if(is_null($organization)){
            return response()->json(['error' => 'not_found']);
        }
        $organization->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
