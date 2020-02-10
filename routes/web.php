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

Route::get('/', function () {
    return view('auth.sign-in');
});

Route::get('/registration', function () {
    return view('auth.registration');
});

Route::get('/create-organization', function () {
    return view('auth.create-organization');
});

Route::get('/sign-up', function () {
    return view('auth.sign-up');
});

Route::get('/sign-in', function () {
    return view('auth.sign-in');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
});

Route::get('/dashboard', function () {
    $data = array (
        'page_title' => 'Dashboard',
        'content_view' => View::make('account.profile')
    );
    return view('template.template', $data);
});

Route::get('/profile', function () {
    return view('account.profile');
});

Route::get('/change-password', function () {
    return view('account.change-password');
});

Route::get('/manage-subscription', function () {
    return view('account.manage-subscription');
});