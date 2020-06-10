<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['json.response', 'cors']], function () {

  //Public endpoints

  /*Auth endpoints*/
  Route::get('/unauthorized', 'Api\AuthController@unauthorized')->name('unauthorized');;
  Route::post('/register', 'Api\AuthController@register')->name('register');;
  Route::post('/activate', 'Api\AuthController@activate')->name('activate');;
  Route::post('/login', 'Api\AuthController@login')->name('login');
  Route::post('/activateaccountemail', 'Api\AuthController@activateaccountemail')->name('activateaccountemail');;
  Route::post('/forgotpasswordemail', 'Api\AuthController@forgotpasswordemail')->name('forgotpasswordemail');;

  /*OrganizationType endpoints*/
  Route::get('/organizationtypes', 'Api\OrganizationTypeController@index');

  /*Organization endpoints*/
  Route::get('/organizations', 'Api\OrganizationController@index');
  Route::post('/organization', 'Api\OrganizationController@store');

  /*Email endpoints*/
  Route::get('/emails/mailing-list/', 'Api\UserController@getMailingListEmails');
  Route::get('/emails/{role}/', 'Api\UserController@getRoleEmails');

  /*Metric endpoints*/
  Route::get('/metric/revenue/{created_date}', 'Api\OrderController@getOrderRevenue');
  Route::get('/metric/{role}/{created_date}', 'Api\UserController@getCreatedRoleUsers');
  Route::post('/metric/orders', 'Api\OrderController@getOrdersByStatus');

  /*Marketing (Deals) endpoints*/
  Route::get('/marketing/deals/{period_date}', 'Api\ProductDealController@getDealsByDate');

  //Private endpoints
  Route::middleware('auth:api')->group(function () {

    /*Role endpoints*/
    Route::get('/roles', 'Api\RoleController@index');
    Route::get('/role/{id}', 'Api\RoleController@show');
    Route::post('/role', 'Api\RoleController@store');
    Route::put('/role/{id}', 'Api\RoleController@update');
    Route::delete('/role/{id}', 'Api\RoleController@destroy');
    Route::get('/role/{id}/menus', 'Api\RoleController@getRoleMenus');

    /*OrganizationType endpoints*/
    Route::get('/organizationtype/{id}', 'Api\OrganizationTypeController@show');
    Route::post('/organizationtype', 'Api\OrganizationTypeController@store');
    Route::put('/organizationtype/{id}', 'Api\OrganizationTypeController@update');
    Route::delete('/organizationtype/{id}', 'Api\OrganizationTypeController@destroy');

    /*Organization endpoints*/
    Route::get('/organization/{id}', 'Api\OrganizationController@show');
    Route::put('/organization/{id}', 'Api\OrganizationController@update');
    Route::delete('/organization/{id}', 'Api\OrganizationController@destroy');
    Route::get('/organization/{id}/offers', 'Api\OrganizationController@getOrganizationOffers');
    Route::get('/organization/{id}/activeoffers', 'Api\OrganizationController@getOrganizationActiveOffers');
    Route::get('/organization/{id}/payment-type', 'Api\OrganizationController@getOrganizationPaymentType');
    Route::get('/organization/{id}/stocks', 'Api\OrganizationController@getOrganizationStocks');
    Route::get('/organization/{id}/stockbalances', 'Api\OrganizationController@getOrganizationAllStockBalances');
    Route::get('/organization/{id}/stockbalances-pricelist', 'Api\OrganizationController@getOrganizationPricelistStockBalances');
    Route::get('/organization/{id}/stocks/{product}', 'Api\OrganizationController@getOrganizationProductStocks');
    Route::get('/organization/{id}/stockbalances/{product}', 'Api\OrganizationController@getOrganizationProductStockBalances');
    Route::get('/organization/{id}/productnows', 'Api\OrganizationController@getOrganizationProductNows');
    Route::get('/organization/{id}/promotions', 'Api\OrganizationController@getOrganizationPromotions');
    Route::get('/organization/{id}/productdeals', 'Api\OrganizationController@getOrganizationProductDeals');
    Route::get('/organization/{id}/orders', 'Api\OrganizationController@getOrganizationOrders');
    Route::get('/organization/{id}/seller-orders', 'Api\OrganizationController@getOrganizationSellerOrders');
    Route::get('/organization/{id}/products', 'Api\OrganizationController@getOrganizationProducts');
    Route::get('/sellers', 'Api\OrganizationController@getSellerOrganizations');
    Route::get('/admins', 'Api\OrganizationController@getAdminOrganizations');
    Route::get('/organization/{id}/unpublished', 'Api\OrganizationController@getUnpublishedProductNows');
    Route::get('/organization/{id}/published', 'Api\OrganizationController@getPublishedProductNows');
    Route::get('/organization/{id}/subscription', 'Api\OrganizationController@getOrganizationSubscription');

    /*Package endpoints*/
    Route::get('/packages', 'Api\PackageController@index');
    Route::get('/package/{id}', 'Api\PackageController@show');
    Route::post('/package', 'Api\PackageController@store');
    Route::put('/package/{id}', 'Api\PackageController@update');
    Route::delete('/package/{id}', 'Api\PackageController@destroy');
    Route::get('/package/{id}/users', 'Api\PackageController@getPackageUsers');

    /*User endpoints*/
    Route::get('/users', 'Api\UserController@index');
    Route::get('/user/{id}', 'Api\UserController@show');
    Route::get('/user/{id}/loyalty', 'Api\UserController@getUserPoints');
    Route::get('/user/{id}/credit', 'Api\UserController@getUserCredits');
    Route::get('/user-admins', 'Api\UserController@getAdminUsers');

    /*Subscription endpoints*/
    Route::get('/subscriptions', 'Api\SubscriptionController@index');
    Route::get('/subscription/{id}', 'Api\SubscriptionController@show');
    Route::post('/subscription', 'Api\SubscriptionController@store');
    Route::put('/subscription/{id}', 'Api\SubscriptionController@update');
    Route::delete('/subscription/{id}', 'Api\SubscriptionController@destroy');

    /*Auth endpoints*/
    Route::post('/changepassword', 'Api\AuthController@changepassword')->name('changepassword');;
    Route::get('/me', 'Api\AuthController@viewprofile')->name('me');
    Route::put('/profile', 'Api\AuthController@updateprofile')->name('profile');
    Route::post('/logout', 'Api\AuthController@logout')->name('logout');;

    /*Menu endpoints*/
    Route::get('/menus', 'Api\MenuController@index');
    Route::get('/menu/{id}', 'Api\MenuController@show');
    Route::post('/menu', 'Api\MenuController@store');
    Route::put('/menu/{id}', 'Api\MenuController@update');
    Route::delete('/menu/{id}', 'Api\MenuController@destroy');

    /*MenuRole endpoints*/
    Route::get('/menu-roles', 'Api\MenuRoleController@index');
    Route::get('/menu-role/{id}', 'Api\MenuRoleController@show');
    Route::post('/menu-role', 'Api\MenuRoleController@store');
    Route::put('/menu-role/{id}', 'Api\MenuRoleController@update');
    Route::delete('/menu-role/{id}', 'Api\MenuRoleController@destroy');

    /*ProductCategory endpoints*/
    Route::get('/product-categories', 'Api\ProductCategoryController@index');
    Route::get('/product-category/{id}', 'Api\ProductCategoryController@show');
    Route::post('/product-category', 'Api\ProductCategoryController@store');
    Route::put('/product-category/{id}', 'Api\ProductCategoryController@update');
    Route::delete('/product-category/{id}', 'Api\ProductCategoryController@destroy');
    Route::get('/product-category/{id}/products', 'Api\ProductCategoryController@getCategoryProducts');

    /*Product endpoints*/
    Route::get('/products', 'Api\ProductController@index');
    Route::get('/product/{id}', 'Api\ProductController@show');
    Route::post('/product', 'Api\ProductController@store');
    Route::put('/product/{id}', 'Api\ProductController@update');
    Route::delete('/product/{id}', 'Api\ProductController@destroy');

    /*Offer endpoints*/
    Route::get('/offers', 'Api\OfferController@index');
    Route::get('/offer/{id}', 'Api\OfferController@show');
    Route::post('/offer', 'Api\OfferController@store');
    Route::put('/offer/{id}', 'Api\OfferController@update');
    Route::delete('/offer/{id}', 'Api\OfferController@destroy');
    Route::get('/offer/{id}/deals', 'Api\OfferController@getOfferDeals');

    /*StockType endpoints*/
    Route::get('/stocktypes', 'Api\StockTypeController@index');
    Route::get('/stocktype/{id}', 'Api\StockTypeController@show');
    Route::post('/stocktype', 'Api\StockTypeController@store');
    Route::put('/stocktype/{id}', 'Api\StockTypeController@update');
    Route::delete('/stocktype/{id}', 'Api\StockTypeController@destroy');

    /*Stock endpoints*/
    Route::get('/stocks', 'Api\StockController@index');
    Route::get('/stock/{id}', 'Api\StockController@show');
    Route::post('/stock', 'Api\StockController@store');
    Route::put('/stock/{id}', 'Api\StockController@update');
    Route::delete('/stock/{id}', 'Api\StockController@destroy');

    /*PaymentType endpoints*/
    Route::get('/payment-types', 'Api\PaymentTypeController@index');
    Route::get('/payment-type/{id}', 'Api\PaymentTypeController@show');
    Route::post('/payment-type', 'Api\PaymentTypeController@store');
    Route::put('/payment-type/{id}', 'Api\PaymentTypeController@update');
    Route::delete('/payment-type/{id}', 'Api\PaymentTypeController@destroy');

    /*OrganizationPaymentType endpoints*/
    Route::get('/organization-payment-types', 'Api\OrganizationPaymentTypeController@index');
    Route::get('/organization-payment-type/{id}', 'Api\OrganizationPaymentTypeController@show');
    Route::post('/organization-payment-type', 'Api\OrganizationPaymentTypeController@store');
    Route::put('/organization-payment-type/{id}', 'Api\OrganizationPaymentTypeController@update');
    Route::delete('/organization-payment-type/{id}', 'Api\OrganizationPaymentTypeController@destroy');

    /*StockBalances endpoints*/
    Route::get('/stockbalances', 'Api\StockBalanceController@index');
    Route::get('/stockbalance/{id}', 'Api\StockBalanceController@show');
    Route::post('/stockbalance', 'Api\StockBalanceController@store');
    Route::put('/stockbalance/{id}', 'Api\StockBalanceController@update');
    Route::delete('/stockbalance/{id}', 'Api\StockBalanceController@destroy');
    Route::post('/stockbatchbalance', 'Api\StockBalanceController@getStockBatchBalance');
    Route::post('/calculatebalance', 'Api\StockBalanceController@CalculateBalance');

    /*ProductNows (pricelist) endpoints*/
    Route::get('/productnows', 'Api\ProductNowController@index');
    Route::get('/productnow/{id}', 'Api\ProductNowController@show');
    Route::post('/productnow', 'Api\ProductNowController@store');
    Route::put('/productnow/{id}', 'Api\ProductNowController@update');
    Route::post('/productnow/{id}', 'Api\ProductNowController@patch');
    Route::delete('/productnow/{id}', 'Api\ProductNowController@destroy');

    /*Promotions endpoints*/
    Route::get('/promotions', 'Api\PromotionController@index');
    Route::get('/promotion/{id}', 'Api\PromotionController@show');
    Route::post('/promotion', 'Api\PromotionController@store');
    Route::put('/promotion/{id}', 'Api\PromotionController@update');
    Route::delete('/promotion/{id}', 'Api\PromotionController@destroy');

    /*ProductDeals endpoints*/
    Route::get('/productdeals', 'Api\ProductDealController@index');
    Route::get('/productdeal/{id}', 'Api\ProductDealController@show');
    Route::post('/productdeal', 'Api\ProductDealController@store');
    Route::put('/productdeal/{id}', 'Api\ProductDealController@update');
    Route::delete('/productdeal/{id}', 'Api\ProductDealController@destroy');

    /*Payments endpoints*/
    Route::get('/payments', 'Api\PaymentController@index');
    Route::get('/payment/{id}', 'Api\PaymentController@show');
    Route::post('/payment', 'Api\PaymentController@store');
    Route::put('/payment/{id}', 'Api\PaymentController@update');
    Route::delete('/payment/{id}', 'Api\PaymentController@destroy');

    /*PaymentPromotions endpoints*/
    Route::get('/paymentpromotions', 'Api\PaymentPromotionController@index');
    Route::get('/paymentpromotion/{id}', 'Api\PaymentPromotionController@show');
    Route::post('/paymentpromotion', 'Api\PaymentPromotionController@store');
    Route::put('/paymentpromotion/{id}', 'Api\PaymentPromotionController@update');
    Route::delete('/paymentpromotion/{id}', 'Api\PaymentPromotionController@destroy');

    /*PaymentDeals endpoints*/
    Route::get('/paymentdeals', 'Api\PaymentDealController@index');
    Route::get('/paymentdeal/{id}', 'Api\PaymentDealController@show');
    Route::post('/paymentdeal', 'Api\PaymentDealController@store');
    Route::put('/paymentdeal/{id}', 'Api\PaymentDealController@update');
    Route::delete('/paymentdeal/{id}', 'Api\PaymentDealController@destroy');

    /*PaymentSubscriptions endpoints*/
    Route::get('/paymentsubscriptions', 'Api\PaymentSubscriptionController@index');
    Route::get('/paymentsubscription/{id}', 'Api\PaymentSubscriptionController@show');
    Route::post('/paymentsubscription', 'Api\PaymentSubscriptionController@store');
    Route::put('/paymentsubscription/{id}', 'Api\PaymentSubscriptionController@update');
    Route::delete('/paymentsubscription/{id}', 'Api\PaymentSubscriptionController@destroy');

    /*Orders endpoints*/
    Route::get('/orders', 'Api\OrderController@index');
    Route::get('/order/{id}', 'Api\OrderController@show');
    Route::post('/order', 'Api\OrderController@store');
    Route::put('/order/{id}', 'Api\OrderController@update');
    Route::delete('/order/{id}', 'Api\OrderController@destroy');
    Route::get('/order/{id}/orderitems', 'Api\OrderController@getOrderItems');
    Route::get('/order/{id}/orderlogs', 'Api\OrderController@getOrderLogs');
    Route::get('/order/{id}/creditlog', 'Api\OrderController@getCreditLog');

    /*OrderItems endpoints*/
    Route::get('/orderitems', 'Api\OrderItemController@index');
    Route::get('/orderitem/{id}', 'Api\OrderItemController@show');
    Route::post('/orderitem', 'Api\OrderItemController@store');
    Route::put('/orderitem/{id}', 'Api\OrderItemController@update');
    Route::delete('/orderitem/{id}', 'Api\OrderItemController@destroy');

    /*OrderLogs endpoints*/
    Route::get('/orderlogs', 'Api\OrderLogController@index');
    Route::get('/orderlog/{id}', 'Api\OrderLogController@show');
    Route::post('/orderlog', 'Api\OrderLogController@store');
    Route::put('/orderlog/{id}', 'Api\OrderLogController@update');
    Route::delete('/orderlog/{id}', 'Api\OrderLogController@destroy');

    /*PaymentOrders endpoints*/
    Route::get('/paymentorders', 'Api\PaymentOrderController@index');
    Route::get('/paymentorder/{id}', 'Api\PaymentOrderController@show');
    Route::post('/paymentorder', 'Api\PaymentOrderController@store');
    Route::put('/paymentorder/{id}', 'Api\PaymentOrderController@update');
    Route::delete('/paymentorder/{id}', 'Api\PaymentOrderController@destroy');

    /*Loyalties endpoints*/
    Route::get('/loyalties', 'Api\LoyaltyController@index');
    Route::get('/loyalty/{id}', 'Api\LoyaltyController@show');
    Route::post('/loyalty', 'Api\LoyaltyController@store');
    Route::put('/loyalty/{id}', 'Api\LoyaltyController@update');
    Route::delete('/loyalty/{id}', 'Api\LoyaltyController@destroy');

    /*LoyaltyLog endpoints*/
    Route::get('/loyaltylogs', 'Api\LoyaltyLogController@index');
    Route::get('/loyaltylog/{id}', 'Api\LoyaltyLogController@show');
    Route::post('/loyaltylog', 'Api\LoyaltyLogController@store');
    Route::put('/loyaltylog/{id}', 'Api\LoyaltyLogController@update');
    Route::delete('/loyaltylog/{id}', 'Api\LoyaltyLogController@destroy');

    /*Credits endpoints*/
    Route::get('/credits', 'Api\CreditController@index');
    Route::get('/credit/{id}', 'Api\CreditController@show');
    Route::post('/credit', 'Api\CreditController@store');
    Route::put('/credit/{id}', 'Api\CreditController@update');
    Route::delete('/credit/{id}', 'Api\CreditController@destroy');

    /*CreditLog endpoints*/
    Route::get('/creditlogs', 'Api\CreditLogController@index');
    Route::get('/creditlog/{id}', 'Api\CreditLogController@show');
    Route::post('/creditlog', 'Api\CreditLogController@store');
    Route::put('/creditlog/{id}', 'Api\CreditLogController@update');
    Route::delete('/creditlog/{id}', 'Api\CreditLogController@destroy');

    /*Refunds endpoints*/
    Route::get('/refunds', 'Api\RefundController@index');
    Route::get('/refund/{id}', 'Api\RefundController@show');
    Route::post('/refund', 'Api\RefundController@store');
    Route::put('/refund/{id}', 'Api\RefundController@update');
    Route::delete('/refund/{id}', 'Api\RefundController@destroy');

    /*PaymentRefunds endpoints*/
    Route::get('/paymentrefunds', 'Api\PaymentRefundController@index');
    Route::get('/paymentrefund/{id}', 'Api\PaymentRefundController@show');
    Route::post('/paymentrefund', 'Api\PaymentRefundController@store');
    Route::put('/paymentrefund/{id}', 'Api\PaymentRefundController@update');
    Route::delete('/paymentrefund/{id}', 'Api\PaymentRefundController@destroy');

    /*Couriers endpoints*/
    Route::get('/couriers', 'Api\CourierController@index');
    Route::get('/courier/{id}', 'Api\CourierController@show');
    Route::post('/courier', 'Api\CourierController@store');
    Route::put('/courier/{id}', 'Api\CourierController@update');
    Route::delete('/courier/{id}', 'Api\CourierController@destroy');

    /*OrderCouriers endpoints*/
    Route::get('/ordercouriers', 'Api\OrderCourierController@index');
    Route::get('/ordercourier/{id}', 'Api\OrderCourierController@show');
    Route::post('/ordercourier', 'Api\OrderCourierController@store');
    Route::put('/ordercourier/{id}', 'Api\OrderCourierController@update');
    Route::delete('/ordercourier/{id}', 'Api\OrderCourierController@destroy');

    /*Payouts endpoints*/
    Route::get('/payouts', 'Api\PayoutController@index');
    Route::get('/payout/{id}', 'Api\PayoutController@show');
    Route::post('/payout', 'Api\PayoutController@store');
    Route::put('/payout/{id}', 'Api\PayoutController@update');
    Route::delete('/payout/{id}', 'Api\PayoutController@destroy');

    /*Credits endpoints*/
    Route::get('/paymentpayouts', 'Api\PaymentPayoutController@index');
    Route::get('/paymentpayout/{id}', 'Api\PaymentPayoutController@show');
    Route::post('/paymentpayout', 'Api\PaymentPayoutController@store');
    Route::put('/paymentpayout/{id}', 'Api\PaymentPayoutController@update');
    Route::delete('/paymentpayout/{id}', 'Api\PaymentPayoutController@destroy');
  });
});
