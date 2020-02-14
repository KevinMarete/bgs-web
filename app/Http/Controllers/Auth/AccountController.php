<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AccountController extends Controller
{
    public function displayView()
    {   
        $view_data = [
            'profile' => $this->getProfile(),
            'organizations' => $this->getOrganizations(),
            'subscriptions' => $this->getSubscriptions(),
            'payment' => $this->getPaymentDetails()
        ];
        $data = ['page_title' => 'Manage Account', 'content_view' => View::make('auth.account', $view_data)];

        return view('template.main', $data);
    }

    public function updateAccount(Request $request)
    {
        $request_data = $request->all();
        return redirect('/account');
    }

    public function changePassword(Request $request)
    {
        $request_data = $request->all();
        return redirect('/account');
    }

    public function cardSubscription(Request $request)
    {
        $request_data = $request->all();
        return redirect('/account');
    }

    public function phoneSubscription(Request $request)
    {
        $request_data = $request->all();
        return redirect('/account');
    }

    public function getProfile()
    {   
        $profile = [
            'firstname' => 'Kevin', 
            'lastname' => 'Marete',
            'email' => 'kevomarete@gmail.com',
            'phone' => '0725102659',
            'organization_id' => '1',
            'subscriptions' => [
                'status' => 'active',
                'start_date' => '2020-02-01',
                'end_date' => date('jS-M-Y', strtotime('2020-03-01')),
                'subscription' => [
                    'id' => '1',
                    'name' => 'Basic',
                ]
            ]
        ];
        return $profile;
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

    public function getSubscriptions()
    {   
        $subscriptions = [
            ['id' => '1', 'name' => 'Basic', 'price' => '1000', 'details' => ['Limited access to promos & deals', 'Limited access to sellers', 'Email support', 'Help center access']],
            ['id' => '2', 'name' => 'Professional', 'price' => '3000', 'details' => ['Medium access to promos & deals', 'Medium access to sellers', 'Priority email support', 'Help center access']],
            ['id' => '3', 'name' => 'Enterprise', 'price' => '5000', 'details' => ['All access to promos & deals', 'All access to sellers', 'Phone and email support', 'Help center access']]
        ];
        return $subscriptions;
    }

    public function getPaymentDetails()
    {   
        $payment = [
            'paybill_number' => '800500',
            'account_number' => 'BGS'
        ];
        return $payment;
    }

}
