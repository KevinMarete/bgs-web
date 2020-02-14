<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignInController extends Controller
{
    public function authenticateAccount(Request $request)
    {
        $request_data = $request->all();
        return redirect('/dashboard');
    }
}
