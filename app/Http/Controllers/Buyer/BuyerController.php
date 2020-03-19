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
        $data = [
            'page_title' => 'Ordernow', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.ordernow')
        ];

        return view('template.main', $data);
    }

    public function displayDealView()
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $data = [
            'page_title' => 'Deals', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.deal')
        ];

        return view('template.main', $data);
    }

    public function displayPromoView()
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $data = [
            'page_title' => 'Promos', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.promo')
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
}
