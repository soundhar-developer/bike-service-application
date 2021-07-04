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
    return view('pages.register');
});
Route::get('/login', function () {
    return view('pages.login');
});

Route::get('/register', function () {
    return view('pages.register');
});

Route::get('/owner', function () {
	if(Auth::user()) {
		if(Auth::user()->user_type == "owner") {
    		return view('pages.owner');
		} else {
			return view('pages.customer');
		}
	} else {
		return redirect('/login');
	}
	
});

Route::get('/customer', function () {
	if(Auth::user()) {
		if(Auth::user()->user_type == "customer") {
	    	return view('pages.customer');
		} else {
			return view('pages.owner');
		}
	} else {
		return redirect('/login');
	}
});

// Route::middleware('auth:api')->get('/home', function () {
//     return view('home');
// });

Route::post('/login', 'AuthController@login'); 
Route::get('/logout', 'AuthController@logout');
Route::post('/registerCustomer', 'AuthController@registerCustomer'); 
Route::post('/addService', 'ServiceController@addService'); 
Route::post('/editService', 'ServiceController@editService'); 
Route::get('/loadAllServices', 'ServiceController@loadAllServices'); 
Route::get('/getService/{serviceId}', 'ServiceController@getService'); 
Route::delete('/deleteService', 'ServiceController@deleteService'); 

Route::post('/addBooking', 'BookingController@addBooking');

Route::get('/loadCurrentBooking', 'BookingController@customerCurrentBooking');

Route::get('/loadPreviousBookingCustomer', 'BookingController@customerPreviousBooking');

Route::get('/loadPendingBooking', 'ServiceController@loadPendingBooking');

Route::get('/loadPreviousBooking', 'ServiceController@loadPreviousBooking');

Route::get('/loadReadyForDeliveryBooking', 'ServiceController@loadReadyForDeliveryBooking'); 

Route::post('/updateBookingStatus', 'ServiceController@updateBookingStatus'); 

