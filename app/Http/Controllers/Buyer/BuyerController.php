<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderEmail;
use App\Mail\CourierEmail;
use App\Mail\NotificationEmail;
use App\Mail\RFQEmail;

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
            $products = $this->getResourceData($token, 'productnows/published');
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

        //Mixpanel Product Promotion
        if ($request->offering === "promotion") {
            $this->mixPanel->track('Product Promotion', [
                'product_id' => $request->productId,
                'organization_id' => $request->organizationId
            ]);
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

            //Mixpanel Product Offer
            $this->mixPanel->track('Product Offer', [
                'product_id' => $request->productId
            ]);
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
                $mail_item = [
                    'product_name' => $order_item['product_name'],
                    'quantity' => $order_item['quantity'],
                    'unit_price' => $order_item['unit_price'],
                    'sub_total' => round(($order_item['sub_total'] - $credits_per_item), 2),
                ];
                $orderitems[] = $mail_item;

                //Add supplier emails
                $supplier_emails[] = $order_item['organization_email'];

                //Mixpanel Product Order
                $this->mixPanel->track('Product Order', $mail_item);
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

    public function displayRFQTableView()
    {
        $resource = 'rfq';

        $token = session()->get('token');
        $organization_id = session()->get('organization_id');
        $role_id = session()->get('organization.organization_type.role_id');
        $role_name = strtolower(session()->get('organization.organization_type.role.name'));

        $rfqs_url = [
            'admin' => 'rfqs',
            'buyer' => 'organization/' . $organization_id . '/rfqs',
            'seller' => 'organization/' . $organization_id . '/seller-rfqs'
        ];

        $view_data = [
            'role_name' => $role_name,
            'resource_name' => $resource,
            'table_headers' => ['Id', 'status', 'created_at', 'organization'],
            'table_data' => $this->getResourceData($token, $rfqs_url[$role_name])
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

        //Filter unique product nows
        $product_nows = [];
        $all_product_nows = $this->getResourceData($token, 'productnows');
        if (sizeof($all_product_nows) > 0) {
            $product_nows = array_reduce($all_product_nows, function ($product_nows, $item) {
                $product_nows[$item['product']['product_category']['name']][mb_strtoupper($item['product']['brand_name']) . '-' . mb_strtoupper($item['product']['molecular_name'])] = $item['id'];
                return $product_nows;
            });
        }

        $view_data = [
            'productnows' => json_encode($product_nows),
            'supplier_categories' => $this->getResourceData($token, 'sellers/suppliercategories'),
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
    {
        $sellers = $request->organizations;
        $product_nows = $request->product_nows;
        $quantity = $request->quantity;
        $total_rfq_cost = $request->total_rfq_cost;
        $status = 'created, awaiting_quotation';
        $transaction_type = 'phone';

        $token = session()->get('token');
        $organization_id = session()->get('organization_id');
        $user_id = session()->get('id');

        //Add payment
        $payment_data = [
            'method' => $transaction_type,
            'amount' => $total_rfq_cost,
            'source' => ['phone' => session()->get('phone')],
            'destination' => ['paybill_number' => env('PAYBILL_NUMBER'), 'account_number' => env('ACCOUNT_NUMBER')]
        ];
        $payment_response = $this->process_payment($token, $organization_id, $user_id, $payment_data);
        $payment_id = $payment_response['id'];

        //Check for Unique Sellers due to duplicate ProductCategories
        $sellers = array_unique(array_map(function ($seller) {
            $seller = explode('#', $seller);
            return $seller[0];
        }, $sellers));

        foreach ($sellers as $seller) {
            $seller = explode('@', $seller);
            $seller_id = $seller[0];
            $seller_emails = $seller[1];

            //Add Rfq
            $rfq_data = [
                'status' => $status,
                'terms' => '',
                'organization_id' => $organization_id
            ];
            $rfq_response = $this->manageResourceData($token, "POST", "rfq", $rfq_data);
            $rfq_id = $rfq_response['id'];

            //Add RfqLog
            $rfqlog_data = [
                'status' => $status,
                'user_id' => $user_id,
                'organization_id' => $organization_id,
                'rfq_id' => $rfq_id
            ];
            $this->manageResourceData($token, "POST", "rfqlog", $rfqlog_data);

            //Add RfqItems
            foreach ($product_nows as $index => $product_now) {
                $product_now = explode('@', $product_now);
                $product_now_id = $product_now[0];
                $product_now_name = $product_now[1];
                $product_qty = $quantity[$index];
                $rfqitem_data = [
                    'quantity' => $product_qty,
                    'unit_price' => 0,
                    'shipping_price' => 0,
                    'sub_total' => 0,
                    'shipping_total' => 0,
                    'total_cost' => 0,
                    'out_of_stock' => false,
                    'product_now_id' => $product_now_id,
                    'organization_id' => $seller_id,
                    'rfq_id' => $rfq_id
                ];
                $this->manageResourceData($token, "POST", "rfqitem", $rfqitem_data);

                //Add payment rfq
                $paymentrfq_data = ['payment_id' => $payment_id, 'rfq_id' => $rfq_id];
                $this->manageResourceData($token, "POST", "paymentrfq", $paymentrfq_data);

                //Add mail rfqitems
                $rfqitems = [
                    'product_name' => $product_now_name,
                    'quantity' => $product_qty,
                ];

                //Mixpanel RFQ Product
                $this->mixPanel->track('Product Quotation', $rfqitems);
            }

            //Send RFQ Email to Seller Copy Buyer and BGS Admins
            $this->sendRFQEmail($token, $rfq_id);
        }

        $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your RFQ(s) have been created successfully.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';

        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('/rfq');
    }

    public function viewRFQ(Request $request)
    {
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');
        $role_name = strtolower(session()->get('organization.organization_type.role.name'));
        $rfq_id = $request->id;

        $view_data = [
            'role_name' => $role_name,
            'rfq' => $this->getResourceData($token, 'rfq/' . $rfq_id)
        ];
        $data = [
            'page_title' => 'rfq',
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.rfq.view', $view_data)
        ];

        return view('template.main', $data);
    }

    public function manageRFQ(Request $request)
    {
        $token = session()->get('token');
        $organization_id = session()->get('organization_id');
        $role_id = session()->get('organization.organization_type.role_id');
        $role_name = strtolower(session()->get('organization.organization_type.role.name'));
        $rfq_id = $request->id;
        $rfq = $this->getResourceData($token, 'rfq/' . $rfq_id);

        $view_data = [
            'rejectreasons' => $this->manageResourceData($token, "GET", "rejectreasons", []),
            'actions' => $this->getRfqActions($role_name, $rfq['status']),
            'organization_id' => $organization_id,
            'role_name' => $role_name,
            'rfq' => $rfq
        ];
        $data = [
            'page_title' => 'rfq',
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.rfq.manage', $view_data)
        ];

        return view('template.main', $data);
    }

    public function getRfqActions($role = null, $status = null)
    {
        $status_actions = [];
        if ($role !== null & $status !== null) {
            $actions = [
                'admin' => [
                    'created, awaiting_quotation' => [],
                    'quotation_sent, awaiting_confirmation' => [],
                    'rejected, quotation_rejected' => [],
                    'accepted, quotation_accepted' => [],
                    'proforma_invoice_sent, awaiting_delivery' => []
                ],
                'seller' => [
                    'created, awaiting_quotation' => [
                        'Send Quotation' => 'quotation_sent, awaiting_confirmation'
                    ],
                    'quotation_sent, awaiting_confirmation' => [],
                    'rejected, quotation_rejected' => [],
                    'accepted, quotation_accepted' => [
                        'Send Proforma Invoice' => 'proforma_invoice_sent, awaiting_delivery',
                    ],
                    'proforma_invoice_sent, awaiting_delivery' => []
                ],
                'buyer' => [
                    'created, awaiting_quotation' => [],
                    'quotation_sent, awaiting_confirmation' => [
                        'Reject' => 'rejected, quotation_rejected',
                        'Accept' => 'accepted, quotation_accepted'
                    ],
                    'rejected, quotation_rejected' => [],
                    'accepted, quotation_accepted' => [],
                    'proforma_invoice_sent, awaiting_delivery' => []
                ]
            ];
            $status_actions = $actions[$role][$status];
        }
        return $status_actions;
    }

    public function actionRFQ(Request $request)
    {
        $rfq_id = $request->id;
        $status = $request->status;
        $rfq_organization_id = $request->organization_id;

        $token = session()->get('token');
        $organization_id = session()->get('organization_id');
        $user_id = session()->get('id');

        //Update RFQ
        $rfq_data = [
            'status' => $status,
            'terms' => $request->terms,
            'organization_id' => $rfq_organization_id
        ];
        $rfq_response = $this->manageResourceData($token, "PUT", "rfq/" . $rfq_id, $rfq_data);
        $rfq_id = $rfq_response['id'];

        //Add RfqLog
        $rfqlog_data = [
            'status' => $status,
            'user_id' => $user_id,
            'organization_id' => $organization_id,
            'rfq_id' => $rfq_id
        ];
        $this->manageResourceData($token, "POST", "rfqlog", $rfqlog_data);

        //Trigger Actions based on status
        $this->triggerRfqStatusAction($token, $status, $request->all());

        $flash_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your quote has been successfully sent to the seller
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';

        $request->session()->flash('bgs_msg', $flash_msg);

        return redirect('/rfq/view/' . $rfq_id);
    }

    public function triggerRfqStatusAction($token, $status = null, $request_data)
    {
        $response = [];
        if ($status !== null) {
            if ($status == 'quotation_sent, awaiting_confirmation') {
                $this->updateRfqItems($token, $request_data);
            } else if ($status == 'rejected, quotation_rejected') {
                $this->addRejectRfq($token, $request_data);
            }
            //Send email notification
            $response = $this->sendRFQEmail($token, $request_data['id']);
        }
        return $response;
    }

    public function updateRfqItems($token, $request_data)
    {
        foreach ($request_data['product_now_id'] as $index => $product_now_id) {
            $item_id = $request_data['item_id'][$index];
            $quantity = $request_data['quantity'][$index];
            $unit_price = $request_data['unit_price'][$index];
            $shipping_price = $request_data['shipping_price'][$index];

            $rfqitem_data = [
                'id' => $item_id,
                'quantity' => $quantity,
                'unit_price' => $unit_price,
                'shipping_price' => $shipping_price,
                'sub_total' => ($quantity * $unit_price),
                'shipping_total' => ($quantity * $shipping_price),
                'total_cost' => ($quantity * $unit_price) + ($quantity * $shipping_price),
                'out_of_stock' => $request_data['out_of_stock'][$index],
                'product_now_id' => $product_now_id,
                'organization_id' => $request_data['seller_id'][$index],
                'rfq_id' => $request_data['id'],
            ];
            $this->manageResourceData($token, "PUT", "rfqitem/" . $item_id, $rfqitem_data);
        }
    }

    public function addRejectRfq($token, $request_data)
    {
        $rfqreject_data = [
            'rfq_id' => $request_data['id'],
            'reject_reason_id' => $request_data['reject_reason_id'],
        ];
        $this->manageResourceData($token, "POST", "rfqreject", $rfqreject_data);
    }

    public function sendRFQEmail($token, $rfq_id)
    {
        //Get Rfq
        $rfq = $this->manageResourceData($token, "GET", "rfq/" . $rfq_id, []);

        $rfq_status = [
            'created, awaiting_quotation' => [
                'to' => 'seller',
                'from' => 'buyer',
                'message' => 'I would like to request a quotation for the products listed below. <br/> <br/> You can view the requested RFQ <a href="' . env('APP_DOMAIN') . '/rfq/manage/' . $rfq_id . '" target="_blank">here</a>.'
            ],
            'quotation_sent, awaiting_confirmation' => [
                'to' => 'buyer',
                'from' => 'seller',
                'message' => 'Please find the quotation as requested. Also note that we have only listed products in stock. <br/> <br/> You can accept/reject the quotation <a href="' . env('APP_DOMAIN') . '/rfq/manage/' . $rfq_id . '" target="_blank">here</a>.'
            ],
            'rejected, quotation_rejected' => [
                'to' => 'seller',
                'from' => 'buyer',
                'message' => 'Unfortunately, I will not be accepting the RFQ terms due to ' . mb_strtolower($rfq['rfq_reject']['reject_reason']['name']) . '.'
            ],
            'accepted, quotation_accepted' => [
                'to' => 'seller',
                'from' => 'buyer',
                'message' => 'I am glad to confirm that we accept the terms of Quotation.'
            ],
            'proforma_invoice_sent, awaiting_delivery' => [
                'to' => 'buyer',
                'from' => 'seller',
                'message' => 'We are glad to receive your confirmation and we shall proceed to deliver the products.'
            ]
        ];

        //Set email data
        $email_data = $rfq;
        $email_data['to_user_description'] = ucwords($rfq_status[$rfq['status']]['to']);
        $email_data['from_user_description'] = ucwords($rfq_status[$rfq['status']]['from']);
        $email_data['overall_sub_total'] = array_reduce($rfq['rfq_items'], function ($tmp_items, $item) {
            if (!$item['out_of_stock']) {
                $tmp_items += $item['sub_total'];
            }
            return $tmp_items;
        });
        $email_data['overall_shipping_total'] = array_reduce($rfq['rfq_items'], function ($tmp_items, $item) {
            if (!$item['out_of_stock']) {
                $tmp_items += $item['shipping_total'];
            }
            return $tmp_items;
        });
        $email_data['overall_total'] = array_reduce($rfq['rfq_items'], function ($tmp_items, $item) {
            if (!$item['out_of_stock']) {
                $tmp_items += $item['total_cost'];
            }
            return $tmp_items;
        });
        $email_data['message'] = $rfq_status[$rfq['status']]['message'];
        $email_data['to'] = $this->getRFQEmails($rfq, $rfq_status[$rfq['status']]['to']);
        $email_data['cc'] = $this->getRFQEmails($rfq, $rfq_status[$rfq['status']]['from']);
        $email_data['bcc'] = $this->getRFQEmails($rfq, 'admin');

        $email_dataobj = json_decode(json_encode($email_data));

        Mail::send(new RFQEmail($email_dataobj));

        return ['status' => 'success', 'message' => 'Action was successful!'];
    }

    public function getRFQEmails($rfq, $description)
    {
        $emails = [];
        if ($description == 'buyer') {
            $emails = array_map(function ($user) {
                return $user['email'];
            }, $rfq['organization']['users']);
        } else if ($description == 'seller') {
            $emails = array_map(function ($user) {
                return $user['email'];
            }, $rfq['rfq_items'][0]['organization']['users']);
        } else {
            $emails = $this->get_admin_emails();
        }
        return $emails;
    }

    public function displaySupportView()
    {
        $token = session()->get('token');
        $role_id = session()->get('organization.organization_type.role_id');

        $view_data = [
            'faqs' => $this->getResourceData($token, 'faqs'),
            'how_tos' => $this->getResourceData($token, 'how-tos'),
        ];
        $data = [
            'page_title' => 'faqs',
            'menus' => $this->getRoleMenus($token, $role_id),
            'content_view' => View::make('buyer.support', $view_data)
        ];

        return view('template.main', $data);
    }
}
