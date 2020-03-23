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
        session()->put('cart_title', $data['page_title']);

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
        session()->put('cart_title', $data['page_title']);

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
        session()->put('cart_title', $data['page_title']);

        return view('template.main', $data);
    }

    public function displayCartView(Request $request)
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $cart_title = session()->get('cart_title');
        $view_data = [
            'cart_items' => session()->get('cart'),
            'back_to_link' => strtolower($cart_title),
            'total' => 0
        ];
        $data = [
            'page_title' => $cart_title, 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.cart', $view_data)
        ];

        return view('template.main', $data);
    }

    public function displayCheckoutView()
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $cart_title = session()->get('cart_title');
        $view_data = [
            'cart_items' => session()->get('cart'),
            'back_to_link' => strtolower($cart_title),
            'total' => 0,
            'shipping' => 0,
            'paybill_number' => env('PAYBILL_NUMBER'),
            'account_number' => env('ACCOUNT_NUMBER')
        ];
        $data = [
            'page_title' => $cart_title, 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.checkout', $view_data)
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

    public function addCart(Request $request)
    {   
        $request_data = $request->except('_token');
        //Add data to session array
        $cart = session()->get('cart');
        $cart[$request_data['product_id']] = $request_data;
        session()->put('cart', $cart);

        $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Item was added successfully to cart
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect()->back();
    }

    public function updateCart(Request $request)
    {   
        $request_data = $request->except('_token');
        $product_id = $request->id;
        //update data to session array
        $cart = session()->get('cart');
        $cart[$product_id]['quantity'] = $request_data['quantity'];
        $cart[$product_id]['sub_total'] = $request_data['price']*$request_data['quantity'];

        session()->put('cart', $cart);

        $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Item was updated successfully on cart
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('cart'); 
    }

    public function removeCart(Request $request)
    {   
        //Remove data from session array
        $cart = session()->pull('cart', []);
        unset($cart[$request->id]);
        session()->put('cart', $cart);

        $flash_msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Item was removed successfully from cart!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';

        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('cart');  
    }

    public function saveOrder(Request $request)
    {   
        $transaction_type = $request->type;
        $token = session()->get('token');
        $organization_id = session()->get('organization_id');
        $user_id = session()->get('id');

        //Send request data to Api
        $response = $this->client->post("order", [
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
}
