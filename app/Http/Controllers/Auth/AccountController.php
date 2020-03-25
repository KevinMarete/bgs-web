<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AccountController extends MyController
{   
    
    public function displayView()
    {   
        $token = session()->get('token');
        $user_id = session()->get('id');
        $role_id = session()->get('organization.organization_type.role_id');
        $view_data = [
            'profile' => $this->getProfile($token),
            'organizations' => $this->getOrganizations(),
            'packages' => $this->getPackages($token),
            'payment' => $this->getPaymentDetails(),
            'subscription' => $this->getUserSubscription($token, $user_id),
            'loyalty' => $this->getUserPoints($token, $user_id),
            'min_redeem' => env('MIN_REDEEM_POINTS')
        ];
        $data = [
            'page_title' => 'Manage Account', 
            'content_view' => View::make('auth.account', $view_data),
            'menus' => $this->getRoleMenus($token, $role_id)
        ];

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

    public function saveSubscription(Request $request)
    {   
        $transaction_type = $request->type;
        $token = session()->get('token');
        $organization_id = session()->get('organization_id');
        $user_id = session()->get('id');

        //Send request data to Api
        $response = $this->client->post("subscription", [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ],
            'json' => $request->all()
        ]);
        $subscription_response = json_decode($response->getBody(), true);
        $subscription_id = $subscription_response['id'];
        
        //Make payment
        $amount = $request->price;
        $payment_response = $this->process_payment($token, $organization_id, $user_id, $amount);
        $payment_id = $payment_response['id'];

        //Send request data to Api for payment
        $response = $this->client->post("paymentsubscription", [
            'headers' => [
                'Authorization' => 'Bearer '.session()->get('token')
            ],
            'json' => ['payment_id' => $payment_id, 'subscription_id' => $subscription_id]
        ]);

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
        $subscription = [
            'status' => 'inactive',
            'start_date' => null,
            'end_date' => null,
            'package' => [
                'id' => null,
                'name' => null
            ]
        ];

        if($token !== null){
            $request = $this->client->get('user/'.$user_id.'/subscription', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token
                ]
            ]);
            $response = json_decode($request->getBody(), true);
            if($response){
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
        }

        return $subscription;
    }

    public function getUserPoints($token=null, $user_id=null)
    {   
        $points = [
            'points' => 0,
            'loyalty_logs' => []
        ];

        if($token !== null){
            $request = $this->client->get('user/'.$user_id.'/loyalty', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token
                ]
            ]);
            $response = json_decode($request->getBody(), true);
            if($response){
                $points = $response;
            }
        }

        return $points;
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
