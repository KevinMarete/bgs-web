<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderEmail;
use App\Mail\CourierEmail;
use App\Mail\NotificationEmail;

class BuyerController extends MyController
{
    public function displayMarketplaceView()
    {
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');

        $display_product_limit = env('DISPLAY_PRODUCT_LIMIT');
        $promotion_slider_limit = env('PROMOTIONS_SLIDER_LIMIT');
        $promotion_static_limit = env('PROMOTIONS_STATIC_LIMIT');
        $display_promotion_static_limit = round(env('PROMOTIONS_STATIC_LIMIT') / 2);

        $static_promotions = $this->getActiveStaticPromotions($token, $promotion_static_limit);

        $view_data = [
            'promotions' => [
                'slider' => $this->getActiveSliderPromotions($token, $promotion_slider_limit),
                'static-left' => array_slice($static_promotions, 0, $display_promotion_static_limit),
                'static-right' => array_slice($static_promotions, $display_promotion_static_limit, $promotion_static_limit),
            ],
            'offers' => $this->getActiveOffers($token, $display_product_limit),
            'top_products' => $this->getTopProducts($token, $display_product_limit)
        ];
        $data = [
            'page_title' => 'Marketplace',
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.marketplace', $view_data)
        ];
        session()->put('cart_title', $data['page_title']);

        return view('template.main', $data);
    }

    public function getActiveSliderPromotions($token, $number_of_promotions)
    {
        $active_promotions = [];
        $promotions = $this->getResourceData($token, 'promotions');
        $count = 0;
        foreach ($promotions as $promotion) {
            if ($promotion['display_date'] == date('Y-m-d') && $promotion['type'] == 'slider' && $count < $number_of_promotions) {
                $active_promotions[] = $promotion;
                $count++;
            }
            if ($count >= $number_of_promotions) {
                break;
            }
        }
        return $active_promotions;
    }

    public function getActiveStaticPromotions($token, $number_of_promotions)
    {
        $active_promotions = [];
        $promotions = $this->getResourceData($token, 'promotions');
        $count = 0;
        foreach ($promotions as $promotion) {
            if ($promotion['display_date'] == date('Y-m-d') && $promotion['type'] == 'static' && $count < $number_of_promotions) {
                $promotion['is_promotion'] = true;
                $active_promotions[] = $promotion;
                $count++;
            }
            if ($count >= $number_of_promotions) {
                break;
            }
        }

        $count = ($number_of_promotions - sizeof($active_promotions));
        if ($count != 0) {
            $product_nows = $this->getResourceData($token, 'productnows');
            //Get only published productnows
            $published_product_nows = array_filter($product_nows, function ($product_now) {
                return ($product_now['is_published'] == true);
            });
            //Randomize the order of array items
            shuffle($published_product_nows);
            while ($count != 0 && sizeof($published_product_nows) >= $count) {
                $active_promotions[] = [
                    'is_promotion' => false,
                    'display_url' => env('PRODUCT_DEFAULT_IMAGE'),
                    'product_now' => $published_product_nows[$count]
                ];
                $count--;
            }
        }
        return $active_promotions;
    }

    public function getActiveOffers($token, $number_of_offers)
    {
        $active_offers = [];
        $offers = $this->getResourceData($token, 'offers');
        $count = 0;
        foreach ($offers as $offer) {
            if (now() >= $offer['valid_from'] && now() <= $offer['valid_until'] && $count < $number_of_offers) {
                $active_offers[] = $offer;
                $count++;
            }
            if ($count >= $number_of_offers) {
                break;
            }
        }
        return $active_offers;
    }

    public function getTopProducts($token, $number_of_products)
    {
        $top_products = [];
        $orderitems = $this->getResourceData($token, 'orderitems');
        $orderitems_count = array_count_values(array_column($orderitems, 'product_now_id'));
        //Sort by value in descending order
        arsort($orderitems_count);
        //Get product_ids from array keys
        $product_ids = array_keys($orderitems_count);
        //Get only products based on limit
        $product_ids = array_slice($product_ids, 0, $number_of_products);

        foreach ($product_ids as $product_id) {
            $top_products[] = $this->getResourceData($token, 'productnow/' . $product_id);
        }
        return $top_products;
    }

    public function sortMultiArray($array, $mapping_keys, $sorting_key, $order = SORT_ASC)
    {
        $mapped_array = array_map(function ($sub_array) use ($mapping_keys) {
            $tmp_map = $sub_array;
            foreach ($mapping_keys as $index => $mapping_key) {
                $tmp_map = $tmp_map[$mapping_key];
                if ((sizeof($mapping_keys) - 1) == $index) {
                    return $tmp_map;
                }
            }
        }, $array);
        $columns = array_column($mapped_array, $sorting_key);
        array_multisort($columns, $order, $array);

        return $array;
    }

    public function displayOrderNowView(Request $request)
    {
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');

        //Sort data flag
        $is_sort = true;

        if ($request->organizationId) {
            $products = $this->getResourceData($token, 'organization/' . $request->organizationId . '/published');
        } else {
            $products = $this->getResourceData($token, 'productnows');
        }

        if ($request->productId) {
            //Sorting 
            $products = $this->sortMultiArray($products, ['product'], 'brand_name', SORT_ASC);
            //Find product in product array
            $key = array_search($request->productId, array_column($products, 'product_id'));
            $tempProduct = $products[$key];
            //Remove product from product array
            unset($products[$key]);
            //Add product to beginning of array
            array_unshift($products, $tempProduct);
            //No sorting of data
            $is_sort = false;
        }

        $view_data = [
            'products_per_page' => env('PRODUCTS_PER_PAGE'),
            'products' => $products,
            'productcategories' => $this->getResourceData($token, 'product-categories'),
            'organizations' => $this->getResourceData($token, 'sellers'),
            'is_sort' => $is_sort,
        ];
        $data = [
            'page_title' => 'Ordernow',
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.ordernow', $view_data)
        ];
        session()->put('cart_title', $data['page_title']);

        return view('template.main', $data);
    }

    public function displayOffersDayView(Request $request)
    {
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');

        //Sort data flag
        $is_sort = true;

        $products = $this->getResourceData($token, 'offers');

        if ($request->productId) {
            //Sorting 
            $products = $this->sortMultiArray($products, ['product_now', 'product'], 'brand_name', SORT_ASC);
            //Find product in product array
            $productNows = array_map(function ($product) {
                return $product['product_now'];
            }, $products);
            $key = array_search($request->productId, array_column($productNows, 'id'));
            $tempProduct = $products[$key];
            //Remove product from product array
            unset($products[$key]);
            //Add product to beginning of array
            array_unshift($products, $tempProduct);
            //No sorting of data
            $is_sort = false;
        }

        $view_data = [
            'products_per_page' => env('PRODUCTS_PER_PAGE'),
            'products' => $products,
            'productcategories' => $this->getResourceData($token, 'product-categories'),
            'organizations' => $this->getResourceData($token, 'sellers'),
            'is_sort' => $is_sort,
        ];
        $data = [
            'page_title' => 'Offers-day',
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.offers_day', $view_data)
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
            'page_title' => 'Cart',
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.cart', $view_data)
        ];

        return view('template.main', $data);
    }

    public function displayCheckoutView()
    {
        $token = session()->get('token');
        $user_id = session()->get('id');
        $role_id = session()->get('organization.organization_type.role_id');
        $cart_title = session()->get('cart_title');
        $credit_response = $this->getResourceData($token, 'user/' . $user_id . '/credit');

        $view_data = [
            'cart_items' => session()->get('cart'),
            'back_to_link' => strtolower($cart_title),
            'total' => 0,
            'shipping' => 0,
            'credits' => (empty($credit_response) ? 0 : $credit_response['amount']),
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

    public function getResourceData($token = null, $resource = null)
    {
        $resource_data = [];
        if ($token !== null && $resource != null) {
            $request = $this->client->get($resource, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
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
        $cart[$product_id]['sub_total'] = $request_data['price'] * $request_data['quantity'];

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

    public function splitOrder($cart_items)
    {
        $orders = [];
        $status = 'paid, awaiting_confirmation';
        $organization_id = session()->get('organization_id');
        $user_id = session()->get('id');

        foreach ($cart_items as $cart_item) {
            $seller_id = $cart_item['organization_id'];
            $sub_total = round($cart_item['sub_total'], 2);
            $shipping_total = round(($cart_item['delivery'] * $cart_item['quantity']), 2);

            if (!in_array($seller_id, array_keys($orders))) {
                //Add new order and log
                $orders[$seller_id] = [
                    'status' => $status,
                    'product_total' => $sub_total,
                    'shipping_total' => $shipping_total,
                    'organization_id' => $organization_id,
                    'order_log' => [
                        'status' => $status,
                        'user_id' => $user_id,
                        'organization_id' => $organization_id
                    ]
                ];
            } else {
                //Update existing order 
                $orders[$seller_id]['product_total'] = round(($orders[$seller_id]['product_total'] + $sub_total), 2);
                $orders[$seller_id]['shipping_total'] = round(($orders[$seller_id]['shipping_total'] + $shipping_total), 2);
            }
            //Add order_item
            $orders[$seller_id]['order_items'][] = [
                'quantity' => $cart_item['quantity'],
                'unit_price' => round($cart_item['price'], 2),
                'shipping_price' => round($cart_item['delivery'], 2),
                'sub_total' => $sub_total,
                'shipping_total' => round($shipping_total, 2),
                'discount' => round($cart_item['discount'], 2),
                'total_cost' => round(($sub_total + $shipping_total), 2),
                'product_now_id' => $cart_item['product_id'],
                'organization_id' => $seller_id,
                'organization_email' => $cart_item['organization_email'],
                'product_name' => $cart_item['product_name']
            ];
        }

        return $orders;
    }

    public function saveOrder(Request $request)
    {
        $cart_items = session()->get('cart');
        $orders = $this->splitOrder($cart_items);
        $token = session()->get('token');
        $transaction_type = $request->type;
        $organization_id = session()->get('organization_id');
        $user_id = session()->get('id');
        $user_points = 0;
        $points_per_order = env('POINTS_PER_ORDER');

        //Get user credits
        $credit_response = $this->getResourceData($token, 'user/' . $user_id . '/credit');
        $credits = (empty($credit_response) ? 0 : $credit_response['amount']);
        $order_size = sizeof($orders);
        $cart_size = sizeof($cart_items);
        $credits_per_order = round(($credits / $order_size), 2);
        $credits_per_item = round(($credits / $cart_size), 2);
        $credits_balance = $credits;

        foreach ($orders as $order) {
            $orderitems = [];
            $supplier_emails = [];
            $credits_balance = round(($credits_balance - $credits_per_order), 2);

            //Add Order 
            $order_data = [
                'status' => $order['status'],
                'product_total' => round(($order['product_total'] - $credits_per_order), 2),
                'shipping_total' => $order['shipping_total'],
                'organization_id' => $order['organization_id']
            ];
            $order_response = $this->manageResourceData($token, "POST", "order", $order_data);
            $order_id = $order_response['id'];

            //Add OrderLog
            $orderlog_data = $order['order_log'];
            $orderlog_data['order_id'] = $order_id;
            $this->manageResourceData($token, "POST", "orderlog", $orderlog_data);

            //Add OrderItems
            foreach ($order['order_items'] as $order_item) {
                $orderitem_data = [
                    'quantity' => $order_item['quantity'],
                    'unit_price' => $order_item['unit_price'],
                    'shipping_price' => $order_item['shipping_price'],
                    'sub_total' => round(($order_item['sub_total'] - $credits_per_item), 2),
                    'shipping_total' => $order_item['shipping_total'],
                    'discount' => $order_item['discount'],
                    'total_cost' => $order_item['total_cost'],
                    'product_now_id' => $order_item['product_now_id'],
                    'organization_id' => $order_item['organization_id'],
                    'order_id' => $order_id
                ];
                $this->manageResourceData($token, "POST", "orderitem", $orderitem_data);

                //Add mail orderitems
                $orderitems[] = [
                    'product_name' => $order_item['product_name'],
                    'quantity' => $order_item['quantity'],
                    'unit_price' => $order_item['unit_price'],
                    'sub_total' => round(($order_item['sub_total'] - $credits_per_item), 2),
                ];

                //Add supplier emails
                $supplier_emails[] = $order_item['organization_email'];
            }

            //Add payment
            $payment_data = [
                'method' => $transaction_type,
                'amount' => round(($order['product_total'] + $order['shipping_total'] - $credits_per_order), 2),
                'source' => $request->source,
                'destination' => $request->destination
            ];
            $payment_response = $this->process_payment($token, $organization_id, $user_id, $payment_data);
            $payment_id = $payment_response['id'];

            //Add payment order
            $paymentorder_data = ['payment_id' => $payment_id, 'order_id' => $order_id];
            $this->manageResourceData($token, "POST", "paymentorder", $paymentorder_data);

            //Get user loyalty points
            $loyalty_response = $this->manageResourceData($token, "GET", "user/" . $user_id . "/loyalty", []);
            if ($loyalty_response) {
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

            //Update Credits if credits_per_order > 0
            if ($credits_per_order > 0) {
                $credit_data = ['amount' => $credits_balance, 'user_id' => $user_id];
                $credit_response = $this->manageResourceData($token, "POST", "credit", $credit_data);
                $credit_id = $credit_response['id'];

                //Add Credit Log
                $creditlog_data = [
                    'status' => 'used_on_order_#' . $order_id,
                    'amount' => $credits_per_order,
                    'credit_id' => $credit_id
                ];
                $this->manageResourceData($token, "POST", "creditlog", $creditlog_data);
            }

            //Send Order Email to Buyer Copy Sellers
            $email_data = [
                'id' => $order_id,
                'product_total' => $order['product_total'],
                'shipping_total' => $order['shipping_total'],
                'orderitems' => $orderitems,
                'user' => ['firstname' => session()->get('firstname'), 'email' => session()->get('email')],
                'supplier_emails' => $supplier_emails,
                'payment_type' => $transaction_type
            ];
            $email_dataobj = json_decode(json_encode($email_data));
            $this->send_mail($email_dataobj);
        }

        //Clear cart
        session()->put('cart', []);

        $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your Order(s) have been created successfully.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';

        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('/orders');
    }

    public function send_mail($order)
    {
        Mail::send(new OrderEmail($order));

        return ['msg' => 'Mail sent'];
    }

    public function displayOrderView()
    {
        $resource = 'orders';
        $resource_name = ucwords(str_replace('-', ' ', $resource));
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $role_name = strtolower(session()->get('organization.organization_type.role.name'));
        $organization_id = session()->get('organization_id');
        $resource_url = $this->getOrderUrl($role_name, $organization_id);
        $view_data = [
            'role_name' => $role_name,
            'resource_name' => $resource_name,
            'table_headers' => $this->getOrderHeaders($role_name),
            'table_data' => $this->getResourceData($token, $resource_url)
        ];
        $data = [
            'page_title' => $resource_name,
            'content_view' => View::make('buyer.orders', $view_data),
            'menus' => $this->getRoleMenus($token, $role_id),
        ];

        return view('template.main', $data);
    }

    public function getOrderHeaders($role = null)
    {
        $headers = [];
        if ($role !== null) {
            $data = [
                'admin' => ['id', 'organization', 'status', 'created_at', 'product_total', 'shipping_total', 'total'],
                'buyer' => ['id', 'status', 'created_at', 'product_total', 'shipping_total', 'total'],
                'seller' => ['id', 'organization', 'status', 'created_at', 'product_total', 'shipping_total', 'total']
            ];
            $headers = $data[$role];
        }
        return $headers;
    }

    public function getOrderUrl($role = null, $id = null)
    {
        $url = '';
        if ($role !== null) {
            $role_url = [
                'admin' => 'orders',
                'buyer' => 'organization/' . $id . '/orders',
                'seller' => 'organization/' . $id . '/seller-orders'
            ];
            $url = $role_url[$role];
        }
        return $url;
    }

    public function displayViewOrder(Request $request)
    {
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $role_name = strtolower(session()->get('organization.organization_type.role.name'));
        $order_id = $request->id;

        $view_data = [
            'role_name' => $role_name,
            'order' => $this->getResourceData($token, 'order/' . $order_id)
        ];
        $data = [
            'page_title' => 'orders',
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.manage.view_order', $view_data)
        ];

        return view('template.main', $data);
    }

    public function displayFaqsView(Request $request)
    {
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $role_name = strtolower(session()->get('organization.organization_type.role.name'));
        $order_id = $request->id;

        $view_data = [];
        $data = [
            'page_title' => 'faqs',
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.faqs', $view_data)
        ];

        return view('template.main', $data);
    }

    public function displayContactUsView(Request $request)
    {
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $role_name = strtolower(session()->get('organization.organization_type.role.name'));
        $order_id = $request->id;

        $view_data = [];
        $data = [
            'page_title' => 'contact-us',
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.contact_us', $view_data)
        ];

        return view('template.main', $data);
    }

    public function displayRFQTableView()
    {
        $resource = 'rfq';

        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $role_name = strtolower(session()->get('organization.organization_type.role.name'));

        $view_data = [
            'role_name' => $role_name,
            'resource_name' => $resource,
            'table_headers' => ['status', 'created_at', 'organization'],
            'table_data' => $this->getResourceData($token, 'rfqs')
        ];
        $data = [
            'page_title' => $resource,
            'content_view' => View::make('buyer.rfq.listing', $view_data),
            'menus' => $this->getRoleMenus($token, $role_id),
        ];

        return view('template.main', $data);
    }

    public function displayNewRFQView()
    {
        $resource = 'rfq';

        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');

        $view_data = [
            'productnows' =>  $this->getResourceData($token, 'productnows'),
            'organizations' =>  $this->getResourceData($token, 'sellers'),
            'rfq_cost' => env('RFQ_COST'),
            'rfq_discount' => env('RFQ_DISCOUNT_COUNT'),
        ];
        $data = [
            'page_title' => ucwords($resource),
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.rfq.new', $view_data)
        ];

        return view('template.main', $data);
    }

    public function saveRFQ(Request $request)
    { }

    public function manageRFQ(Request $request)
    { }

    public function displayActionOrder(Request $request)
    {
        $token = session()->get('token');
        $organization_id = session()->get('organization_id');
        $role_id = session()->get('organization.organization_type.role_id');
        $role_name = strtolower(session()->get('organization.organization_type.role.name'));
        $order_id = $request->id;
        $order = $this->getResourceData($token, 'order/' . $order_id);

        $view_data = [
            'couriers' => $this->manageResourceData($token, "GET", "couriers", []),
            'actions' => $this->getOrderActions($role_name, $order['status']),
            'organization_id' => $organization_id,
            'role_name' => $role_name,
            'order' => $order
        ];
        $data = [
            'page_title' => 'orders',
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.manage.action_order', $view_data)
        ];

        return view('template.main', $data);
    }

    public function getOrderActions($role = null, $status = null)
    {
        $status_actions = [];
        if ($role !== null & $status !== null) {
            $actions = [
                'admin' => [
                    'paid, awaiting_confirmation' => [],
                    'cancelled, awaiting_refund' => [
                        'refund' => 'refunded, order_cancelled'
                    ],
                    'refunded, order_cancelled' => [],
                    'confirmed, awaiting_dispatch' => [
                        'dispatch' => 'dispatched, awaiting_pickup'
                    ],
                    'dispatched, awaiting_pickup' => [],
                    'picked_up, awaiting_delivery' => [
                        'delivered' => 'delivered, order_closed'
                    ],
                    'delivered, order_closed' => []
                ],
                'seller' => [
                    'paid, awaiting_confirmation' => [
                        'cancel' => 'cancelled, awaiting_refund',
                        'confirm' => 'confirmed, awaiting_dispatch'
                    ],
                    'cancelled, awaiting_refund' => [],
                    'refunded, order_cancelled' => [],
                    'confirmed, awaiting_dispatch' => [],
                    'dispatched, awaiting_pickup' => [
                        'picked-up' => 'picked_up, awaiting_delivery'
                    ],
                    'picked_up, awaiting_delivery' => [],
                    'delivered, order_closed' => []
                ],
                'buyer' => [
                    'paid, awaiting_confirmation' => [],
                    'cancelled, awaiting_refund' => [],
                    'refunded, order_cancelled' => [],
                    'confirmed, awaiting_dispatch' => [],
                    'dispatched, awaiting_pickup' => [],
                    'picked_up, awaiting_delivery' => [],
                    'delivered, order_closed' => []
                ]
            ];
            $status_actions = $actions[$role][$status];
        }
        return $status_actions;
    }

    public function actionOrder(Request $request)
    {
        $token = session()->get('token');
        $organization_id = session()->get('organization_id');
        $order_organization_id = $request->organization_id;
        $user_id = session()->get('id');
        $order_id = $request->id;
        $status = $request->status;

        //Trigger Actions based on status
        $trigger_response = $this->triggerStatusAction($status, $request->all());
        if ($trigger_response['status'] == 'success') {
            //Update Order 
            $order_data = [
                'status' => $status,
                'product_total' => $request->product_total,
                'shipping_total' => $request->shipping_total,
                'organization_id' => $order_organization_id
            ];
            $order_response = $this->manageResourceData($token, "PUT", "order/" . $order_id, $order_data);
            $order_id = $order_response['id'];

            //Add OrderLog
            $orderlog_data = [
                'status' => $status,
                'user_id' => $user_id,
                'organization_id' => $organization_id,
                'order_id' => $order_id
            ];
            $this->manageResourceData($token, "POST", "orderlog", $orderlog_data);

            $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your action was successful on Order#' . $order_id . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
        } else {
            $flash_msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> ' . $trigger_response['message'] . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
        }
        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('/view-order/' . $order_id);
    }

    public function triggerStatusAction($status = null, $request_data)
    {
        $response = [];
        $order_id = $request_data['id'];
        if ($status !== null) {
            if ($status == 'refunded, order_cancelled') {
                //Trigger Refund
                $response = $this->refundOrder($order_id);
            } else if ($status == 'dispatched, awaiting_pickup') {
                //Trigger Courier Dispatch
                $response = $this->sendOrderCourier($order_id, $request_data['courier_id']);
            } else if ($status == 'delivered, order_closed') {
                //Trigger Payout
                $response = $this->payoutOrder($order_id);
            } else {
                $response = ['status' => 'success', 'message' => 'Action was successful!'];
            }

            //Notify Buyer
            if ($response['status'] = 'success') {
                $this->sendNotification($order_id, $status);
            }
        }
        return $response;
    }

    public function refundOrder($order_id)
    {
        $token = session()->get('token');
        $organization_id = session()->get('organization_id');
        $user_id = session()->get('id');
        $response = ['status' => 'error', 'message' => 'Refund was unsuccessful'];

        //Get Order 
        $order = $this->manageResourceData($token, "GET", "order/" . $order_id, []);

        //Get Organization PaymentType
        $payment_type = $order['order_logs'][0]['user'];

        if (!empty($payment_type)) {
            //Add refund
            $refund_data = ['status' => 'order_cancelled', 'order_id' => $order_id];
            $refund_response = $this->manageResourceData($token, "POST", "refund", $refund_data);
            $refund_id = $refund_response['id'];

            //Add payment
            $payment_data = [
                'method' => 'mobile',
                'amount' => ($order['product_total'] + $order['shipping_total'] - env('REFUND_FEE')),
                'source' => [
                    'paybill_number' => env('PAYBILL_NUMBER'),
                    'account_number' => env('ACCOUNT_NUMBER')
                ],
                'destination' => ['phone' => $payment_type['phone']]
            ];
            $payment_response = $this->process_payment($token, $organization_id, $user_id, $payment_data);
            $payment_id = $payment_response['id'];

            //Add payment refund
            $paymentrefund_data = ['payment_id' => $payment_id, 'refund_id' => $refund_id];
            $this->manageResourceData($token, "POST", "paymentrefund", $paymentrefund_data);

            //Get buyer loyalty points
            $user_points = 0;
            $buyer_id = $order['order_logs'][0]['user_id'];
            $points_per_order = env('POINTS_PER_ORDER');
            $loyalty_response = $this->manageResourceData($token, "GET", "user/" . $buyer_id . "/loyalty", []);
            if ($loyalty_response) {
                $user_points = $loyalty_response['points'];
            }

            //Return Loyalty Points
            $loyalty_data = ['points' => ($user_points - $points_per_order), 'user_id' => $user_id];
            $loyalty_response = $this->manageResourceData($token, "POST", "loyalty", $loyalty_data);
            $loyalty_id = $loyalty_response['id'];

            //Add Loyalty Points Log
            $loyaltylog_data = [
                'status' => 'order_refund',
                'points' => $points_per_order,
                'order_id' => $order_id,
                'loyalty_id' => $loyalty_id
            ];
            $this->manageResourceData($token, "POST", "loyaltylog", $loyaltylog_data);

            //Get buyer credits
            $credit_response = $this->getResourceData($token, 'user/' . $buyer_id . '/credit');
            $credits_balance = (empty($credit_response) ? 0 : $credit_response['amount']);

            //Get order credits
            $credits_per_order = 0;
            $creditlog_response = $this->manageResourceData($token, "GET", "order/" . $order_id . "/creditlog", []);
            $credits_per_order = (empty($creditlog_response) ? 0 : $creditlog_response['amount']);

            //Return Credits if credits_per_order > 0
            if ($credits_per_order > 0) {
                $credit_data = ['amount' => round(($credits_balance + $credits_per_order), 2), 'user_id' => $buyer_id];
                $credit_response = $this->manageResourceData($token, "POST", "credit", $credit_data);
                $credit_id = $credit_response['id'];

                //Add Credit Log
                $creditlog_data = [
                    'status' => 'refund_on_order_#' . $order_id,
                    'amount' => round((-1 * abs($credits_per_order)), 2),
                    'credit_id' => $credit_id
                ];
                $this->manageResourceData($token, "POST", "creditlog", $creditlog_data);
            }

            $response = ['status' => 'success', 'message' => 'Refund#' . $refund_id . ' was successful'];
        }

        return $response;
    }

    public function sendOrderCourier($order_id, $courier_id)
    {
        $token = session()->get('token');
        $response = ['status' => 'error', 'message' => 'Courier was not assigned'];

        //Get Order 
        $order = $this->manageResourceData($token, "GET", "order/" . $order_id, []);

        //Add Order Courier 
        $order_courier_data = ['order_id' => $order_id, 'courier_id' => $courier_id];
        $order_courier_response = $this->manageResourceData($token, "POST", "ordercourier", $order_courier_data);

        if (!empty($order_courier_response)) {
            //Get Courier
            $courier = $this->manageResourceData($token, "GET", "courier/" . $courier_id, []);

            //Send email to courier
            $email_data = [
                'id' => $order_id,
                'product_total' => ($order['product_total']),
                'shipping_total' => $order['shipping_total'],
                'orderitems' => $order['order_items'],
                'courier' => ['contact' => $courier['contact'], 'email' => $courier['email']],
                'seller' => $order['order_items'][0]['organization'],
                'buyer' => $order['organization']
            ];
            $email_dataobj = json_decode(json_encode($email_data));

            Mail::send(new CourierEmail($email_dataobj));

            $response = ['status' => 'success', 'message' => 'Courier was assigned successfully!'];
        }
        return $response;
    }

    public function payoutOrder($order_id)
    {
        $token = session()->get('token');
        $organization_id = session()->get('organization_id');
        $user_id = session()->get('id');
        $response = ['status' => 'error', 'message' => 'Payout was unsuccessful'];

        //Get Order 
        $order = $this->manageResourceData($token, "GET", "order/" . $order_id, []);

        //Get Organization PaymentType
        $seller_id = $order['order_items'][0]['organization']['id'];
        $payment_type = $this->manageResourceData($token, "GET", "organization/" . $seller_id . "/payment-type", []);

        if (!empty($payment_type)) {
            //Add Payout
            $payout_data = ['order_id' => $order_id, 'organization_id' => $seller_id];
            $payout_response = $this->manageResourceData($token, "POST", "payout", $payout_data);
            $payout_id = $payout_response['id'];

            //Add payment
            $payment_data = [
                'method' => 'mobile',
                'amount' => ($order['product_total'] + $order['shipping_total']),
                'source' => [
                    'paybill_number' => env('PAYBILL_NUMBER'),
                    'account_number' => env('ACCOUNT_NUMBER')
                ],
                'destination' => json_decode($payment_type['details'], true)
            ];
            $payment_response = $this->process_payment($token, $organization_id, $user_id, $payment_data);
            $payment_id = $payment_response['id'];

            //Add payment payout
            $paymentpayout_data = ['payment_id' => $payment_id, 'payout_id' => $payout_id];
            $this->manageResourceData($token, "POST", "paymentpayout", $paymentpayout_data);

            $response = ['status' => 'success', 'message' => 'Payout#' . $payout_id . ' was successful'];
        }

        return $response;
    }

    public function sendNotification($order_id, $status)
    {
        $token = session()->get('token');

        //Get Order 
        $order = $this->manageResourceData($token, "GET", "order/" . $order_id, []);

        //Send notification to buyer
        $buyer = $order['order_logs'][0]['user'];
        $email_data = [
            'id' => $order_id,
            'product_total' => $order['product_total'],
            'shipping_total' => $order['shipping_total'],
            'orderitems' => $order['order_items'],
            'user' => ['firstname' => $buyer['firstname'], 'email' => $buyer['email']],
            'status' => $status
        ];
        $email_dataobj = json_decode(json_encode($email_data));

        Mail::send(new NotificationEmail($email_dataobj));

        return ['status' => 'success', 'message' => 'Notification sent'];
    }
}
