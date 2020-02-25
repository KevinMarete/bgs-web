<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AdminController extends MyController
{   

    public function displayDashboardView()
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $data = [
            'page_title' => 'Dashboard', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('admin.dashboard')
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
            'content_view' => View::make('admin.table', $view_data),
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
                'organizationtypes' => ['id', 'name', 'role'],
                'packages' => ['id', 'name', 'price', 'details'],
                'roles' => ['id', 'name'],
                'product-categories' => ['id', 'name'],
                'stocktypes' => ['id', 'name'],
                'payment-types' => ['id', 'name', 'details'],
            ];
            $header_data = $headers[$resource];
        }

        return $header_data;
    }
}
