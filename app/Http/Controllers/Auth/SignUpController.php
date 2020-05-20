<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SignUpController extends Controller
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
        $data = [
            'organizations' => $this->getOrganizations()
        ];
        return view('auth.sign-up', $data);
    }

    public function saveAccount(Request $request)
    {
        //Check if passwords match 
        if ($request->password !== $request->cpassword) {
            $flash_msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Your passwords do not match, please confirm again
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            $request->session()->flash('bgs_msg', $flash_msg);
            return redirect('/sign-up');
        }

        //Send request data to Api
        $response = $this->client->post("register", ['json' => $request->all()]);
        $response = json_decode($response->getBody(), true);

        //Send Account Email 
        $response = $this->client->post("activateaccountemail", ['json' => ['id' => $response['id']]]);
        $response = json_decode($response->getBody(), true);

        //Set flash message for View
        $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your account was created successfully. Check your email for the account activation code.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('/sign-up');
    }

    public function getOrganizations()
    {
        $request = $this->client->get('organizations');
        $response = $request->getBody();
        $organizations = json_decode($response, true);
        return $organizations;
    }
}
