<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BuyerController extends MyController
{   

    public function displaySearchView()
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $data = [
            'page_title' => 'Search', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.search')
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
}
