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
        Route::get('/organization/{id}/payment-types', 'Api\OrganizationController@getOrganizationPaymentTypes');
        Route::get('/organization/{id}/stocks', 'Api\OrganizationController@getOrganizationStocks');

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
        Route::get('/user/{id}/subscription', 'Api\UserController@getUserSubscription');

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
        Route::get('/offer/{id}/promos', 'Api\OfferController@getOfferPromos');
        Route::get('/offer/{id}/deals', 'Api\OfferController@getOfferDeals');

        /*Promo endpoints*/
        Route::get('/promos', 'Api\PromoController@index');
        Route::get('/promo/{id}', 'Api\PromoController@show');
        Route::post('/promo', 'Api\PromoController@store');
        Route::put('/promo/{id}', 'Api\PromoController@update');
        Route::delete('/promo/{id}', 'Api\PromoController@destroy');

        /*Deal endpoints*/
        Route::get('/deals', 'Api\DealController@index');
        Route::get('/deal/{id}', 'Api\DealController@show');
        Route::post('/deal', 'Api\DealController@store');
        Route::put('/deal/{id}', 'Api\DealController@update');
        Route::delete('/deal/{id}', 'Api\DealController@destroy');

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

        /*StockOffer endpoints*/
        Route::get('/stock-offers', 'Api\StockOfferController@index');
        Route::get('/stock-offer/{id}', 'Api\StockOfferController@show');
        Route::post('/stock-offer', 'Api\StockOfferController@store');
        Route::put('/stock-offer/{id}', 'Api\StockOfferController@update');
        Route::delete('/stock-offer/{id}', 'Api\StockOfferController@destroy');

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

    });

});