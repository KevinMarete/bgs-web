<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

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

    public function manageResourceData($token=null, $rest_method=null, $resource=null, $request_data=null)
    {   
        $response = $this->client->request($rest_method, $resource, [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ],
            'json' => $request_data
        ]);

        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function process_payment($token=null, $organization_id, $user_id=null, $payment_data=[])
    {   
        $response = [];
        if(!empty($payment_data) && $token != null && $organization_id != null && $user_id != null)
        {   
            
            //ADD PAYMENT INTEGRATION HERE

            $response = $this->client->request('POST', 'payment', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token
                ],
                'json' => [
                    'amount' => $payment_data['amount'],
                    'details' => json_encode([
                        'transaction_code' => strtoupper(Str::random(8)), 
                        'transaction_time' => date('Y:m:d H:i:s'), 
                        'transaction_status' => 'successful'
                    ]),
                    'organization_id' => $organization_id,
                    'user_id' => $user_id
                ]
            ]);
            $response = json_decode($response->getBody(), true);
        }
        return $response;
    }
}