<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class MyController extends Controller
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