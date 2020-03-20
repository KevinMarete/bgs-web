<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BuyerController extends MyController
{   

    public function displayOrderNowView()
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $view_data = [
            'products' => $this->getResourceData($token, 'productnows')
        ];
        $data = [
            'page_title' => 'Ordernow', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.ordernow', $view_data)
        ];

        return view('template.main', $data);
    }

    public function displayDealView()
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $view_data = [
            'products' => $this->getResourceData($token, 'productdeals')
        ];
        $data = [
            'page_title' => 'Deals', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.deal', $view_data)
        ];

        return view('template.main', $data);
    }

    public function displayPromoView()
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $view_data = [
            'products' => $this->getResourceData($token, 'productpromos')
        ];
        $data = [
            'page_title' => 'Promos', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.promo', $view_data)
        ];

        return view('template.main', $data);
    }

    public function displayCartView()
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $data = [
            'page_title' => 'Cart', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.cart')
        ];

        return view('template.main', $data);
    }

    public function displayCheckoutView()
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $data = [
            'page_title' => 'Checkout', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.checkout')
        ];

        return view('template.main', $data);
    }

    public function getResourceData($token=null, $resource=null)
    {   
        $resource_data = [];
        if($token !== null && $resource != null){
            $request = $this->client->get($resource, [
                'headers' => [
                    'Authorization' => 'Bearer '.$token
                ]
            ]);
            $response = $request->getBody();
            $resource_data = json_decode($response, true);
        }

        return $resource_data;
    }
}
