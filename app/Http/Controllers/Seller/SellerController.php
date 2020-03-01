<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

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
        $organization_id = session()->get('organization_id');
        $view_data = [
            'resource_name' => $resource_name,
            'table_headers' => $this->getResourceKeys($resource),
            'table_data' => $this->getResourceData($token, 'organization/'.$organization_id.'/'.$resource)
        ];
        $data = [
            'page_title' => $resource_name, 
            'content_view' => View::make('seller.table', $view_data),
            'menus' => $this->getRoleMenus($token, $role_id),
        ];

        return view('template.main', $data);
    }

    public function displayBalancesTableView(Request $request)
    {   
        $resource = 'stockbalances';
        $resource_name = ucwords(str_replace('-', ' ', $resource));
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $organization_id = session()->get('organization_id');
        $view_data = [
            'resource_name' => $resource_name,
            'table_headers' => $this->getResourceKeys($resource),
            'table_data' => $this->getResourceData($token, 'organization/'.$organization_id.'/'.$resource)
        ];
        $data = [
            'page_title' => $resource_name, 
            'content_view' => View::make('seller.balances_table', $view_data),
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
                'offers' => ['id', 'description', 'valid_from', 'valid_until', 'discount', 'max_discount_amount', 'organization'],
                'stockbalances' => ['molecular_name', 'brand_name', 'pack_size', 'balance']
            ];
            $header_data = $headers[$resource];
        }

        return $header_data;
    }

    public function displayManageView(Request $request)
    {   
        $resource_name = $request->resource;
        $singular_resource_name = Str::singular($resource_name);
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $view_data = $this->getDropDownData($token, $resource_name);
        $view_data['manage_label'] = 'new';

        if($request->action){
            if($request->action == 'edit'){
                $view_data['manage_label'] = 'update';
                $view_data['edit'] = $this->getResourceData($token, $singular_resource_name.'/'.$request->id);
            }else{
                if($request->action == 'new'){
                    $response = $this->manageResourceData($token, 'POST', $singular_resource_name, $request->except('_token'));
                }else if($request->action == 'update'){
                    $response = $this->manageResourceData($token, 'PUT', $singular_resource_name.'/'.$request->id, $request->except('_token'));
                }else if($request->action == 'delete'){
                    $response = $this->manageResourceData($token, 'DELETE', $singular_resource_name.'/'.$request->id, $request->except('_token'));
                }

                //Handle response
                if(isset($response['error'])){
                    $flash_msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> '.$response["error"].'
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                }else{
                    $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> '.ucwords($singular_resource_name).' was managed successfully
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                }
                $request->session()->flash('bgs_msg', $flash_msg);
                return redirect('/'.$resource_name);
            }
        }

        $data = [
            'page_title' => ucwords($resource_name), 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('seller.manage.'.$resource_name, $view_data)
        ];

        return view('template.main', $data);
    }

    public function getDropDownData($token=null, $resource=null)
    {   
        $dropdown_data = [];
        $data_sources = [
            'offers' => ['organizations'],
            'stockbalances' => ['products', 'stocktypes']
        ];

        if ($token !== null && $resource !== null){   
            foreach($data_sources[$resource] as $data_source){
                $dropdown_data[str_replace('-', '_', $data_source)] = $this->getResourceData($token, $data_source);
            }
        }
        
        return $dropdown_data;
    }

    public function manageResourceData($token=null, $rest_method=null, $resource=null, $request_data=null)
    {   
        $response = $this->client->request($rest_method, $resource, [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ],
            'json' => $request_data
        ]);

        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function displayTransactionView(Request $request)
    {   
        $resource_name = 'stockbalances';
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $view_data = $this->getDropDownData($token, $resource_name);
        $data = [
            'page_title' => 'Stocks', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('seller.transactions', $view_data)
        ];

        return view('template.main', $data);
    }

    public function displayBinCardView(Request $request)
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $organization_id = session()->get('organization_id');
        $product_id = $request->product;
        $view_data = [
            'product' => $this->getResourceData($token, 'product/'.$product_id),
            'stocks' => $this->getResourceData($token, 'organization/'.$organization_id.'/stocks/'.$product_id),
            'balances' => $this->getResourceData($token, 'organization/'.$organization_id.'/stockbalances/'.$product_id)
        ];
        $data = [
            'page_title' => 'Stocks', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('seller.bincard', $view_data)
        ];

        return view('template.main', $data);
    }

    public function saveTransactions(Request $request)
    {   
        $post_data = $request->all();
        $organization_id = session()->get('organization_id');
        $user_id = session()->get('id');
        $errors = 0;

        foreach($post_data['product_id'] as $key=> $product_id)
        {   
            $batch_number = $post_data['batch_number'][$key];
            $expiry_date = $post_data['expiry_date'][$key];
            $quantity = $post_data['quantity'][$key];
            $stock_type_id = $post_data['stock_type_id'];

            //Get balance
            $balance_data = $this->getExpectedBalance([
                'batch_number' => $batch_number,
                'expiry_date' => $expiry_date,
                'quantity' => $quantity,
                'product_id' => $product_id,
                'stock_type_id' => $stock_type_id,
                'organization_id' => $organization_id
            ]);

            //Build request object
            $request_data = [
                'transaction_date' => $post_data['transaction_date'],
                'batch_number' => $batch_number,
                'expiry_date' => $expiry_date,
                'quantity' => $balance_data['quantity'],
                'balance' => $balance_data['closing_balance'],
                'product_id' => $product_id,
                'stock_type_id' => $stock_type_id,
                'organization_id' => $organization_id,
                'user_id' => $user_id,
            ];
            
            //Send request data to Api
            $response = $this->client->post("stock", [
                'headers' => [
                    'Authorization' => 'Bearer '.session()->get('token')
                ],
                'json' => $request_data
            ]);
            
            $response = json_decode($response->getBody(), true);

            //Check success
            if(isset($response['error'])){
                $errors += 1;
            }
        }

        if($errors > 0){
            $flash_msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> '.$errors.' transactions were not added successfully
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
        }else{
            $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your transactions were added successfully
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
        }

        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('/stocks');
    }

    public function getExpectedBalance($request_data=[])
    {   
        $response_data = [];
        if(!empty($request_data))
        {
            //Send request data to Api
            $response = $this->client->post("calculatebalance", [
                'headers' => [
                    'Authorization' => 'Bearer '.session()->get('token')
                ],
                'json' => $request_data
            ]);
            
            $response_data = json_decode($response->getBody(), true);   
        }
        return $response_data;
    }
}