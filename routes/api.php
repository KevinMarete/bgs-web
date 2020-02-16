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

        /*OrganizationType endpoints*/
        Route::get('/organizationtype/{id}', 'Api\OrganizationTypeController@show');
        Route::post('/organizationtype', 'Api\OrganizationTypeController@store');
        Route::put('/organizationtype/{id}', 'Api\OrganizationTypeController@update');
        Route::delete('/organizationtype/{id}', 'Api\OrganizationTypeController@destroy');

        /*Organization endpoints*/
        Route::get('/organization/{id}', 'Api\OrganizationController@show');
        Route::put('/organization/{id}', 'Api\OrganizationController@update');
        Route::delete('/organization/{id}', 'Api\OrganizationController@destroy');

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

    });

});