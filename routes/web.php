<?php

use Illuminate\Support\Facades\Route;

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
    // return view('welcome');
 return redirect('/customers'); 
});

Route::resource('customers', 'App\\Http\\Controllers\\CustomersController');
Route::get('load-address', 'App\\Http\\Controllers\\CustomersController@load_address');
Route::match(['post','patch'],'validate-customers-form', 'App\\Http\\Controllers\\CustomersController@validate_customers_form');