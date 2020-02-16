<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use GuzzleHttp\Client;

class AccountController extends Controller
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
        $user_id = session()->get('id');
        $view_data = [
            'profile' => $this->getProfile($token),
            'organizations' => $this->getOrganizations(),
            'packages' => $this->getPackages($token),
            'payment' => $this->getPaymentDetails(),
            'subscription' => $this->getUserSubscription($token, $user_id)
        ];
        $data = ['page_title' => 'Manage Account', 'content_view' => View::make('auth.account', $view_data)];

        return view('template.main', $data);
    }

    public function updateAccount(Request $request)
    {
        //Send request data to Api
        $response = $this->client->put("profile", [
            'headers' => [
                'Authorization' => 'Bearer '.session()->get('token')
            ],
            'json' => $request->all()
        ]);
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
                            <strong>Success!</strong> '.$response["msg"].'
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
        }
        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('/account');
    }

    public function changePassword(Request $request)
    {
        //Send request data to Api
        $response = $this->client->post("changepassword", [
            'headers' => [
                'Authorization' => 'Bearer '.session()->get('token')
            ],
            'json' => $request->all()
        ]);
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
                            <strong>Success!</strong> '.$response["msg"].'
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
        }
        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('/account');
    }

    public function cardSubscription(Request $request)
    {
        //Send request data to Api
        $response = $this->client->post("subscription", [
            'headers' => [
                'Authorization' => 'Bearer '.session()->get('token')
            ],
            'json' => $request->all()
        ]);
        $response = json_decode($response->getBody(), true);

        $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your subscription has been updated.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';

        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('/account');
    }

    public function phoneSubscription(Request $request)
    {
        //Send request data to Api
        $response = $this->client->post("subscription", [
            'headers' => [
                'Authorization' => 'Bearer '.session()->get('token')
            ],
            'json' => $request->all()
        ]);
        $response = json_decode($response->getBody(), true);

        $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your subscription has been updated.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';

        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('/account');
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
    
    public function getUserSubscription($token=null, $user_id=null)
    {   
        $subscription = [];

        if($token !== null){
            $request = $this->client->get('user/'.$user_id.'/subscription', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token
                ]
            ]);
            $response = json_decode($request->getBody(), true);

            $subscription = [
                'status' => ( date('Y-m-d', strtotime($response['end_date'])) >= date('Y-m-d') ? 'active' : 'inactive'),
                'start_date' => $response['start_date'],
                'end_date' => date('jS-M-Y', strtotime($response['end_date'])),
                'package' => [
                    'id' => $response['package']['id'],
                    'name' => $response['package']['id']
                ]
            ];
        }

        return $subscription;
    }

    public function getOrganizations()
    {   
        $request = $this->client->get('organizations');
        $response = $request->getBody();
        $types = json_decode($response, true);
        return $types;
    }

    public function getPackages($token=null)
    {   
        $packages = [];
        if($token !== null){
            $request = $this->client->get('packages', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token
                ]
            ]);
            $response = $request->getBody();
            $packages = json_decode($response, true);
        }
        return $packages;
    }

    public function getPaymentDetails()
    {   
        $payment = [
            'paybill_number' => env('PAYBILL_NUMBER'),
            'account_number' => env('ACCOUNT_NUMBER')
        ];
        return $payment;
    }

    public function logout(Request $request)
    {   
        //Send request data to Api
        $response = $this->client->post("logout", [
            'headers' => [
                'Authorization' => 'Bearer '.session()->get('token')
            ]
        ]);
        $response = json_decode($response->getBody(), true);

        //Clear sessions
        $request->session()->flush();

        if(isset($response['msg'])){
            $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> '.$response["msg"].'
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
            $request->session()->flash('bgs_msg', $flash_msg);
        }

        return redirect('/sign-in');
    }

}
