<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ForgotPasswordController extends Controller
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
    
    public function resetAccount(Request $request)
    {
        $request_data = $request->all();
        //Send request data to Api
        $response = $this->client->post("forgotpasswordemail", ['json' => $request->all()]);
        $response = json_decode($response->getBody(), true);

        //Set flash message for View
        $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your account has been reset. Check your email for your new password.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('/forgot-password');
    }
}
