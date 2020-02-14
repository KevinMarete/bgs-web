<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateOrganizationController extends Controller
{
    public function displayView()
    {
        $data = [
            'types' => $this->getOrgTypes()
        ];
        return view('auth.create-organization', $data);
    }

    public function saveOrganization(Request $request)
    {
        $request_data = $request->all();
        return redirect('/registration');
    }

    public function getOrgTypes()
    {   
        $types = [
            ['id' => '1', 'name' => 'Hospital', 'role' => 'buyer'],
            ['id' => '2', 'name' => 'Chemist', 'role' => 'buyer'],
            ['id' => '3', 'name' => 'Clinic', 'role' => 'buyer'],
            ['id' => '4', 'name' => 'Distributor', 'role' => 'seller'],
            ['id' => '5', 'name' => 'Supplier', 'role' => 'seller']
        ];
        return $types;
    }

}
