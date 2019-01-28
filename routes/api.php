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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'userController@store')->name('newRegister');
Route::post('/login', 'userController@login')->name('login');
// user
Route::post('/user/', 'userController@info')->name('userInfo');

Route::post('/user/phone', 'userController@phoneStore')->name('updatePhone');

Route::post('/user/signup', 'userController@store')->name('newRegister');

Route::post('/user/login', 'userController@login')->name('userLogin');

Route::post('/user/medsos', 'userController@medsos')->name('loginMedsos');

Route::post('/booking', 'bookingController@store')->name('newBooking');
Route::post('/booking/history', 'bookingController@history')->name('historyBooking');

Route::get('/product/{category}', 'productController@index')->name('indexProduct');

Route::post('/booking/history','bookingController@history');

Route::post('/available-time', 'timeController@index')->name('availableTime');
Route::get('/busy', 'timeController@busy')->name('busy');
Route::post('/refresh', 'userController@refreshToken');
Route::post('/inbox', 'userController@inbox');


Route::get('/search/{name}', 'userController@searchUser');
Route::get('/booking/name/{name}', 'bookingController@searchUser');
Route::get('/booking/date/{name}', 'bookingController@searchDate');
