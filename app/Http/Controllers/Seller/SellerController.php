<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SellerController extends MyController
{   
    
    public function displayCatalogueView()
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $data = [
            'page_title' => 'Catalogue', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('seller.catalogue')
        ];

        return view('template.main', $data);
    }

    public function displayTableView(Request $request)
    {   
        $resource = $request->path();
        $resource_name = ucwords(str_replace('-', ' ', $resource));
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $view_data = [
            'resource_name' => $resource_name,
            'table_headers' => $this->getResourceKeys($resource),
            'table_data' => $this->getResourceData($token, $resource)
        ];
        $data = [
            'page_title' => $resource_name, 
            'content_view' => View::make('seller.table', $view_data),
            'menus' => $this->getRoleMenus($token, $role_id),
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

    public function getResourceKeys($resource=null)
    {
        $header_data = [];
        if($resource != null){
            $headers = [
                'products' => ['id', 'molecular_name', 'brand_name', 'pack_size', 'product_category', 'minimum_order_quantity', 'unit_price', 'delivery_cost'],
                'offers' => ['id', 'description', 'valid_from', 'valid_until', 'discount', 'max_discount_amount', 'organization'],
                'stocks' => ['id', 'product', 'stock_type', 'transaction_date', 'batch_number', 'expiry_date', 'quantity', 'balance', 'organization']
            ];
            $header_data = $headers[$resource];
        }

        return $header_data;
    }
}
