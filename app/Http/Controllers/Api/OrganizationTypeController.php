<?php

namespace App\Http\Controllers\Api;

use App\OrganizationType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizationtypes = OrganizationType::all();
        return response()->json($organizationtypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, OrganizationType::$rules);
        $organizationtype = OrganizationType::firstOrCreate([
            'name' => $request->name,
            'role_id' => $request->role_id,
        ], $request->all());
        return response()->json($organizationtype);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organizationtype = OrganizationType::find($id);
        if(is_null($organizationtype)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($organizationtype);
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
        $this->validate($request, OrganizationType::$rules);
        $organizationtype  = OrganizationType::find($id);
        if(is_null($organizationtype)){
            return response()->json(['error' => 'not_found']);
        }
        $organizationtype->update($request->all());
        return response()->json($organizationtype);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organizationtype = OrganizationType::find($id);
        if(is_null($organizationtype)){
            return response()->json(['error' => 'not_found']);
        }
        $organizationtype->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }
}
