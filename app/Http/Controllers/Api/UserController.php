<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use App\Loyalty;
use App\Credit;
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
        $users = User::with('organization', 'organization.organization_type', 'organization.organization_type.role')->get();
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
        if (is_null($user)) {
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
        if (is_null($user)) {
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
        if (is_null($user)) {
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

    /**
     * Display the specified user's loyalty points.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUserPoints($id)
    {
        $points = Loyalty::with(['loyalty_logs', 'loyalty_logs.order', 'user'])->where('user_id', $id)->first();
        return response()->json($points);
    }

    /**
     * Display the specified user's credits.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUserCredits($id)
    {
        $points = Credit::with(['credit_logs', 'user'])->where('user_id', $id)->first();
        return response()->json($points);
    }

    /**
     * Display All Role Emails
     *
     * @param  string  $role_name
     * @return \Illuminate\Http\Response
     */
    public function getRoleEmails($role_name)
    {
        $role_emails = User::whereHas('organization.organization_type.role', function ($query) use ($role_name) {
            $query->where('name', $role_name);
        })->select('email')->get();
        return response()->json($role_emails);
    }

    /**
     * Display Count of all new Users by role based on specified_date
     *
     * @param  string  $role_name
     * @param  date  $created_date
     * @return \Illuminate\Http\Response
     */
    public function getCreatedRoleUsers($role_name, $created_date)
    {
        $role_users = User::with(['organization', 'organization.organization_type', 'organization.organization_type.role'])->whereHas('organization.organization_type.role', function ($query) use ($role_name) {
            $query->where('name', $role_name);
        })->whereDate('created_at', $created_date)->get();
        return response()->json(['role' => $role_name, 'total' => sizeof($role_users)]);
    }

    /**
     * Display All MailingList Emails
     *
     * @param  string  $role_name
     * @return \Illuminate\Http\Response
     */
    public function getMailingListEmails()
    {
        $mailing_list_emails = User::where('is_mailing_list', 1)->select('email')->get();
        return response()->json($mailing_list_emails);
    }

    /**
     * Display the all admin users.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAdminUsers()
    {
        $admin_users = User::with(['organization', 'organization.organization_type', 'organization.organization_type.role'])->whereHas('organization.organization_type.role', function ($query) {
            $query->where('name', 'admin');
        })->get();
        return response()->json($admin_users);
    }
}
