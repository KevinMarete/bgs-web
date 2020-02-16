<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SignInController extends Controller
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

    public function authenticateAccount(Request $request)
    {
        //Send request data to Api
        $response = $this->client->post("login", ['json' => $request->all()]);
        $response = json_decode($response->getBody(), true);

        if(isset($response['error'])){
            if(isset($response['user_id'])){
                $flash_msg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Issue!</strong> '.$response["error"].' Please click <a href="/activate-account">Here</a> to verify account!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
            }else{
                $flash_msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> '.$response["error"].'
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
            }
            $request->session()->flash('bgs_msg', $flash_msg);
            return redirect('/sign-in');
        }else{
            //Store session variables
            $token = $response['token'];
            session()->put('token', $token);
            session($this->getProfile($token));
            $fullname = session()->get('firstname').' '.session()->get('lastname');

            //Set flash message to View
            $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Welcome '.$fullname.' to BGS Meds
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
            $request->session()->flash('bgs_msg', $flash_msg);

            return redirect('/dashboard');
        }
    }

    public function activateAccount(Request $request)
    {
        //Send request data to Api
        $response = $this->client->post("activate", ['json' => $request->all()]);
        $response = json_decode($response->getBody(), true);

        if(isset($response['error'])){
            $flash_msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> '.$response["error"].'
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
        }else{
            $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your account was activated successfully. Please proceed to Login
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
        }
        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('/activate-account');
    }

    public function getProfile($token=null)
    {   
        $profile = [];
        if($token !== null){
            $request = $this->client->get('me', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token
                ]
            ]);
            $response = $request->getBody();
            $profile = json_decode($response, true);
        }

        return $profile;
    }
}
