<?php

namespace App\Http\Controllers\Api;

use App\Role;
use App\MenuRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Role::$rules);
        $role = Role::firstOrCreate([
            'name' => $request->name
        ], $request->all());
        return response()->json($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        if(is_null($role)){
            return response()->json(['error' => 'not_found']);
        }
        return response()->json($role);
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
        $this->validate($request, Role::$rules);
        $role  = Role::find($id);
        if(is_null($role)){
            return response()->json(['error' => 'not_found']);
        }
        $role->update($request->all());
        return response()->json($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if(is_null($role)){
            return response()->json(['error' => 'not_found']);
        }
        $role->delete();
        return response()->json(['msg' => 'Removed successfully']);
    }

    /**
     * Display the specified Role's menus.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getRoleMenus($id)
    {
        $menuroles = MenuRole::with('menu', 'role')->where('role_id', $id)->get();
        return response()->json($menuroles);
    }
}
