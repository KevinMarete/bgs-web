<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignUpController extends Controller
{
    public function displayView()
    {
        $data = [
            'organizations' => $this->getOrganizations()
        ];
        return view('auth.sign-up', $data);
    }

    public function saveAccount(Request $request)
    {
        $request_data = $request->all();
        return redirect('/sign-in');
    }

    public function getOrganizations()
    {   
        $types = [
            ['id' => '1', 'name' => 'Maisha Poa Clinic'],
            ['id' => '2', 'name' => 'Kenyatta National Hospital'],
            ['id' => '3', 'name' => 'Neem Pharmacy']
        ];
        return $types;
    }
}
