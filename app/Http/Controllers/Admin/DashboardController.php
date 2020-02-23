<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use GuzzleHttp\Client;

class DashboardController extends Controller
{   
    protected $client;

    public function __construct()
    {   
        //Setup Curl client
        $this->client = new Client([
            'base_uri' => env('API_URL'),
            'defaults' => [
                'exceptions' => false
            ],
            'timeout'  => 10.0
        ]); 
    }

    public function displayView()
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $data = [
            'page_title' => 'Dashboard', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('admin.dashboard')
        ];

        return view('template.main', $data);
    }

    public function getRoleMenus($token=null, $role_id=null)
    {
        $menus = [];
        if($token !== null){
            $request = $this->client->get('role/'.$role_id.'/menus', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token
                ]
            ]);
            $response = $request->getBody();
            $menus = json_decode($response, true);
        }
        return $menus;
    }
}