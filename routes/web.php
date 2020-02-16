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
Route::post('/card-subscription', 'Auth\AccountController@cardSubscription'); 
Route::post('/mobile-subscription', 'Auth\AccountController@phoneSubscription'); 
Route::get('/sign-out', 'Auth\AccountController@logout'); 

/*Stub Dashboard*/
Route::get('/dashboard', function () {
    $data = array (
        'page_title' => 'Dashboard',
        'content_view' => View::make('admin.dashboard')
    );
    return view('template.main', $data);
});