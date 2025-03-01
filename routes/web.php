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

//Public endpoints

/*Landing Routes*/
Route::get('/', 'Auth\LandingController@displayView');
Route::get('/home', 'Auth\LandingController@displayView');
Route::get('/about', 'Auth\LandingController@displayView');
Route::get('/solution', 'Auth\LandingController@displayView');

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

/*Email Routes*/
Route::get('/email/metrics/{period_date?}', 'Admin\AdminController@sendBusinessMetrics');
Route::get('/email/offers/{period_date?}', 'Admin\AdminController@sendOffers');

//Private routes
Route::middleware('usersession')->group(function () {

    /*Manage Account*/
    Route::get('/account', 'Auth\AccountController@displayView');
    Route::post('/update-account', 'Auth\AccountController@updateAccount');
    Route::post('/change-password', 'Auth\AccountController@changePassword');
    Route::post('/save-subscription/{type}', 'Auth\AccountController@saveSubscription');
    Route::post('/manage-payment', 'Auth\AccountController@manageAccountPayment');
    Route::post('/redeem-points', 'Auth\AccountController@redeemPoints');
    Route::get('/sign-out', 'Auth\AccountController@logout');

    /*Seller Routes*/
    Route::get('/pricelist', 'Seller\SellerController@displayPricelistTableView');
    Route::get('/pricelist/new', 'Seller\SellerController@displayNewPricelistView');
    Route::post('/pricelist/save', 'Seller\SellerController@savePricelist');
    Route::get('/pricelist/import', 'Seller\SellerController@displayImportPricelistView');
    Route::post('/pricelist/import', 'Seller\SellerController@importPricelist');
    Route::get('/pricelist/publish', 'Seller\SellerController@displayPublishPricelistView');
    Route::post('/pricelist/publish', 'Seller\SellerController@publishPricelist');
    Route::post('/pricelist/{action}', 'Seller\SellerController@managePricelist');
    Route::get('/pricelist/{action}/{id}', 'Seller\SellerController@managePricelist');
    Route::get('/stocks', 'Seller\SellerController@displayStocksTableView');
    Route::get('/stocks/new', 'Seller\SellerController@displayNewStockTransactionView');
    Route::post('/stocks/save', 'Seller\SellerController@saveStocks');
    Route::get('/stocks/view/{productId}', 'Seller\SellerController@displayStockBinCardView');
    Route::get('/promotions', 'Seller\SellerController@displayPromotionsTableView');
    Route::get('/promotions/new/{type}', 'Seller\SellerController@displayNewPromotionView');
    Route::post('/promotions/save', 'Seller\SellerController@savePromotions');
    Route::post('/promotions/{action}', 'Seller\SellerController@managePromotions');
    Route::get('/promotions/{action}/{type}/{id}', 'Seller\SellerController@managePromotions');
    Route::get('/offers', 'Seller\SellerController@displayOffersTableView');
    Route::post('/offers/save', 'Seller\SellerController@saveOffers');
    Route::get('/offers/{action}', 'Seller\SellerController@manageOffers'); //new
    Route::post('/offers/{action}', 'Seller\SellerController@manageOffers'); //update
    Route::get('/offers/{action}/{id}', 'Seller\SellerController@manageOffers'); //edit or delete

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
    Route::get('/couriers', 'Admin\AdminController@displayTableView');
    Route::get('/users', 'Admin\AdminController@displayTableView');
    Route::get('/manage/{resource}', 'Admin\AdminController@displayManageView');
    Route::post('/manage/{resource}/{action}', 'Admin\AdminController@displayManageView');
    Route::get('/manage/{resource}/{action}/{id}', 'Admin\AdminController@displayManageView');
    Route::post('/manage/{resource}/{action}/{id}', 'Admin\AdminController@displayManageView');
    Route::post('/add-admin-account', 'Admin\AdminController@saveAdminAccount');
    Route::get('/rejectreasons', 'Admin\AdminController@displayTableView');
    Route::get('/faqs', 'Admin\AdminController@displayTableView');
    Route::get('/how-tos', 'Admin\AdminController@displayTableView');
    Route::post('/dashfilter', 'Admin\AdminController@setDashFilter');
    Route::get('/organizations', 'Admin\AdminController@displayTableView');
    Route::get('/organizationsuppliercategories', 'Admin\AdminController@displayTableView');

    /*Buyer Routes*/
    Route::get('/marketplace', 'Buyer\BuyerController@displayMarketplaceView');
    Route::get('/ordernow', 'Buyer\BuyerController@displayOrderNowView');
    Route::get('/ordernow/{productId}', 'Buyer\BuyerController@displayOrderNowView');
    Route::get('/ordernow/{productId}/{organizationId}', 'Buyer\BuyerController@displayOrderNowView');
    Route::get('/ordernow/{productId}/{organizationId}/{offering}', 'Buyer\BuyerController@displayOrderNowView');
    Route::get('/offers-day', 'Buyer\BuyerController@displayOffersDayView');
    Route::get('/offers-day/{productId}', 'Buyer\BuyerController@displayOffersDayView');
    Route::post('/add-cart', 'Buyer\BuyerController@addCart');
    Route::get('/cart', 'Buyer\BuyerController@displayCartView');
    Route::post('/update-cart/{id}', 'Buyer\BuyerController@updateCart');
    Route::get('/remove-cart/{id}', 'Buyer\BuyerController@removeCart');
    Route::get('/checkout', 'Buyer\BuyerController@displayCheckoutView');
    Route::post('/save-order/{type}', 'Buyer\BuyerController@saveOrder');
    Route::get('/orders', 'Buyer\BuyerController@displayOrderView');
    Route::get('/view-order/{id}', 'Buyer\BuyerController@displayViewOrder');
    Route::get('/action-order/{id}', 'Buyer\BuyerController@displayActionOrder');
    Route::post('/action-order/{id}', 'Buyer\BuyerController@actionOrder');
    Route::get('/support', 'Buyer\BuyerController@displaySupportView');
    Route::get('/rfq', 'Buyer\BuyerController@displayRFQTableView');
    Route::get('/rfq/new', 'Buyer\BuyerController@displayNewRFQView');
    Route::post('/rfq/save', 'Buyer\BuyerController@saveRFQ');
    Route::get('/rfq/view/{id}', 'Buyer\BuyerController@viewRFQ');
    Route::get('/rfq/manage/{id}', 'Buyer\BuyerController@manageRFQ');
    Route::post('/rfq/action/{id}', 'Buyer\BuyerController@actionRFQ');
});
