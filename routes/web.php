<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Default Route*/
Route::get('/', function () {
    return view('auth.sign-in');
});

/*Registration*/
Route::get('/registration', function () {
    return view('auth.registration');
});

/*Organization*/
Route::get('/create-organization', 'Auth\CreateOrganizationController@displayView'); 
Route::post('/add-organization', 'Auth\CreateOrganizationController@saveOrganization');

/*Sign-Up*/
Route::get('/sign-up', 'Auth\SignUpController@displayView'); 
Route::post('/add-account', 'Auth\SignUpController@saveAccount');

/*Sign-In*/
Route::get('/sign-in', function () {
    return view('auth.sign-in');
});
Route::post('/authenticate', 'Auth\SignInController@authenticateAccount');

/*Activate-Account*/
Route::get('/activate-account', function () {
    return view('auth.activate-account');
});
Route::post('/activation', 'Auth\SignInController@activateAccount');

/*Forgot-Password*/
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
});
Route::post('/reset-account', 'Auth\ForgotPasswordController@resetAccount');

/*Manage Account*/
Route::get('/account', 'Auth\AccountController@displayView');
Route::post('/update-account', 'Auth\AccountController@updateAccount');
Route::post('/change-password', 'Auth\AccountController@changePassword');
Route::post('/save-subscription/{type}', 'Auth\AccountController@saveSubscription'); 
Route::get('/sign-out', 'Auth\AccountController@logout'); 

/*Seller Routes*/
Route::get('/catalogue', 'Seller\SellerController@displayCatalogueView');  
Route::get('/manage-ordernows', 'Seller\SellerController@displayOrderNowView'); 
Route::get('/manage-promos', 'Seller\SellerController@displayPromoView');  
Route::get('/manage-deals', 'Seller\SellerController@displayDealView');   
Route::get('/offers', 'Seller\SellerController@displayTableView'); 
Route::get('/manage/offers', 'Seller\SellerController@displayOfferView');
Route::post('/manage/offers/{action}', 'Seller\SellerController@displayOfferView');
Route::get('/manage/offers/{action}/{id}', 'Seller\SellerController@displayOfferView');
Route::post('/manage/offers/{action}/{id}', 'Seller\SellerController@displayOfferView');
Route::post('/save-ordernows', 'Seller\SellerController@saveOrderNows');
Route::get('/manage/productnows', 'Seller\SellerController@displayProductNowView');
Route::post('/manage/productnows/{action}', 'Seller\SellerController@displayProductNowView');
Route::get('/manage/productnows/{action}/{id}', 'Seller\SellerController@displayProductNowView');
Route::post('/manage/productnows/{action}/{id}', 'Seller\SellerController@displayProductNowView');
Route::post('/save-productpromos', 'Seller\SellerController@saveProductPromos');
Route::get('/manage/productpromos', 'Seller\SellerController@displayProductPromoView');
Route::post('/manage/productpromos/{action}', 'Seller\SellerController@displayProductPromoView');
Route::get('/manage/productpromos/{action}/{id}', 'Seller\SellerController@displayProductPromoView');
Route::post('/manage/productpromos/{action}/{id}', 'Seller\SellerController@displayProductPromoView');
Route::post('/save-productdeals', 'Seller\SellerController@saveProductDeals');
Route::get('/manage/productdeals', 'Seller\SellerController@displayProductDealView');
Route::post('/manage/productdeals/{action}', 'Seller\SellerController@displayProductDealView');
Route::get('/manage/productdeals/{action}/{id}', 'Seller\SellerController@displayProductDealView');
Route::post('/manage/productdeals/{action}/{id}', 'Seller\SellerController@displayProductDealView');
Route::get('/stocks', 'Seller\SellerController@displayBalancesTableView');
Route::get('/stock-transactions', 'Seller\SellerController@displayTransactionView');
Route::post('/save-transactions', 'Seller\SellerController@saveTransactions');
Route::get('/bin-card/{product}', 'Seller\SellerController@displayBinCardView');

/*Admin Routes*/
Route::get('/dashboard', 'Admin\AdminController@displayDashboardView'); 
Route::get('/organizationtypes', 'Admin\AdminController@displayTableView'); 
Route::get('/packages', 'Admin\AdminController@displayTableView'); 
Route::get('/roles', 'Admin\AdminController@displayTableView'); 
Route::get('/product-categories', 'Admin\AdminController@displayTableView'); 
Route::get('/stocktypes', 'Admin\AdminController@displayTableView'); 
Route::get('/payment-types', 'Admin\AdminController@displayTableView'); 
Route::get('/products', 'Admin\AdminController@displayTableView'); 
Route::get('/menus', 'Admin\AdminController@displayTableView'); 
Route::get('/menu-roles', 'Admin\AdminController@displayTableView'); 
Route::get('/manage/{resource}', 'Admin\AdminController@displayManageView');
Route::post('/manage/{resource}/{action}', 'Admin\AdminController@displayManageView');
Route::get('/manage/{resource}/{action}/{id}', 'Admin\AdminController@displayManageView');
Route::post('/manage/{resource}/{action}/{id}', 'Admin\AdminController@displayManageView');

/*Buyer Routes*/
Route::get('/ordernow', 'Buyer\BuyerController@displayOrderNowView'); 
Route::get('/deals', 'Buyer\BuyerController@displayDealView'); 
Route::get('/promos', 'Buyer\BuyerController@displayPromoView'); 
Route::post('/add-cart', 'Buyer\BuyerController@addCart'); 
Route::get('/cart', 'Buyer\BuyerController@displayCartView'); 
Route::post('/update-cart/{id}', 'Buyer\BuyerController@updateCart'); 
Route::get('/remove-cart/{id}', 'Buyer\BuyerController@removeCart'); 
Route::get('/checkout', 'Buyer\BuyerController@displayCheckoutView'); 
Route::post('/save-order/{type}', 'Buyer\BuyerController@saveOrder'); 
Route::get('/orders', 'Buyer\BuyerController@displayOrderView'); 
Route::get('/view-order/{id}', 'Buyer\BuyerController@displayViewOrder'); 