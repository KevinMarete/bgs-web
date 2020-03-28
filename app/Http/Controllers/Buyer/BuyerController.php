<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderEmail;

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
        $status = 'paid, awaiting_confirmation';
        $product_total = session()->get('product_total');
        $shipping_total = session()->get('shipping_total');
        $cart_items = session()->get('cart');
        $total_amount = ($product_total + $shipping_total);
        $points_per_order = env('POINTS_PER_ORDER');
        $orderitems = []; 
        $supplier_emails = []; 
        $user_points = 0;

        //Add Order 
        $order_data = [
            'status' => $status,
            'product_total' => $product_total,
            'shipping_total' => $shipping_total,
            'organization_id' => $organization_id
        ];
        $order_response = $this->manageResourceData($token, "POST", "order", $order_data);
        $order_id = $order_response['id'];

        //Add OrderLog
        $orderlog_data = [
            'status' => $status,
            'user_id' => $user_id,
            'organization_id' => $organization_id,
            'order_id' => $order_id
        ];
        $this->manageResourceData($token, "POST", "orderlog", $orderlog_data);

        //Add OrderItems
        foreach($cart_items as $cart_item)
        {
            $orderitem_data = [
                'quantity' => $cart_item['quantity'],
                'unit_price' => $cart_item['price'],
                'shipping_price' => $cart_item['delivery'],
                'sub_total' => $cart_item['sub_total'],
                'shipping_total' => ($cart_item['delivery']*$cart_item['quantity']),
                'discount' => $cart_item['discount'],
                'total_cost' => ($cart_item['sub_total'] + ($cart_item['delivery']*$cart_item['quantity'])),
                'product_now_id' => $cart_item['product_id'],
                'organization_id' => $cart_item['organization_id'],
                'order_id' => $order_id
            ];
            $this->manageResourceData($token, "POST", "orderitem", $orderitem_data);

            //Add mail orderitems
            $orderitems[] = [
                'product_name' => $cart_item['product_name'], 
                'quantity' => $cart_item['quantity'], 
                'unit_price'=> $cart_item['price'], 
                'sub_total'=> $cart_item['sub_total'], 
            ];

            //Add supplier emails
            $supplier_emails[] = $cart_item['organization_email'];
        }

        //Add payment
        $payment_data = [
            'method' => $transaction_type,
            'amount' => $total_amount,
            'source' => $request->source,
            'destination' => $request->destination
        ];
        $payment_response = $this->process_payment($token, $organization_id, $user_id, $payment_data);
        $payment_id = $payment_response['id'];

        //Add payment order
        $paymentorder_data = ['payment_id' => $payment_id, 'order_id' => $order_id];
        $this->manageResourceData($token, "POST", "paymentorder", $paymentorder_data);

        //Get user points
        $loyalty_response = $this->manageResourceData($token, "GET", "user/".$user_id."/loyalty", []);
        if($loyalty_response)
        {
            $user_points = $loyalty_response['points'];
        }

        //Add Loyalty Points
        $loyalty_data = ['points' => ($user_points + $points_per_order), 'user_id' => $user_id];
        $loyalty_response = $this->manageResourceData($token, "POST", "loyalty", $loyalty_data);
        $loyalty_id = $loyalty_response['id'];

        //Add Loyalty Points Log
        $loyaltylog_data = [
            'status' => 'earned_from_order',
            'points' => $points_per_order,
            'order_id' => $order_id,
            'loyalty_id' => $loyalty_id
        ];
        $this->manageResourceData($token, "POST", "loyaltylog", $loyaltylog_data);

        //Clear cart
        session()->put('cart', []);

        //Send Order Email to Buyer Copy BGS, bcc Sellers
        $email_data = [
            'id' => $order_id,
            'product_total' => $product_total,
            'shipping_total' => $shipping_total,
            'orderitems' => $orderitems,
            'user' => ['firstname' => session()->get('firstname'), 'email' => session()->get('email')],
            'supplier_emails' => $supplier_emails,
            'payment_type' => $transaction_type
        ];
        $email_dataobj = json_decode(json_encode($email_data));
        $this->send_mail($email_dataobj);

        $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your Order has been created successfully.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';

        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('/orders');
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

    public function send_mail($order)
    {
        Mail::send(new OrderEmail($order));
        
        return ['msg'=> 'Mail sent'];
    }

    public function displayOrderView()
    {   
        $resource = 'orders';
        $resource_name = ucwords(str_replace('-', ' ', $resource));
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $organization_id = session()->get('organization_id');
        $view_data = [
            'resource_name' => $resource_name,
            'table_headers' => ['id', 'status', 'created_at', 'product_total', 'shipping_total', 'total'],
            'table_data' => $this->getResourceData($token, 'organization/'.$organization_id.'/'.$resource)
        ];
        $data = [
            'page_title' => $resource_name, 
            'content_view' => View::make('buyer.orders', $view_data),
            'menus' => $this->getRoleMenus($token, $role_id),
        ];

        return view('template.main', $data);
    }

    public function displayViewOrder(Request $request)
    {   
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $order_id = $request->id;

        $view_data = [
            'order' => $this->getResourceData($token, 'order/'.$order_id)
        ];
        $data = [
            'page_title' => 'orders', 
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.manage.view_order', $view_data)
        ];

        return view('template.main', $data);
    }
}
