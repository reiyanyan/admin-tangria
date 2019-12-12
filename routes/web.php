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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/booking','bookingController@index')->name('bookingPage');
Route::get('/booking/{id}','bookingController@infoWeb')->name('bookingInfo');
Route::get('/booking/cancel/{id}','bookingController@bookingCancel')->name('bookingCancel');
Route::get('/booking/done/{id}','bookingController@bookingDone')->name('bookingDone');


Route::get('/product','productController@home')->name('productPage');
Route::post('/product','productController@save')->name('saveProduct');
Route::post('/product/update','productController@update')->name('updateProduct');
Route::get('/product/new/','productController@new')->name('newProduct');
Route::get('/product/{id}','productController@productInfo')->name('productInfo');
Route::get('/product/delete/{id}','productController@deleteProduct')->name('deleteProduct');

Route::get('/user','userController@index')->name('userPage');
Route::get('/user/block/{id}','userController@block')->name('blockUser');
Route::get('/user/edit/{id}','userController@editWeb')->name('editUser');
Route::post('/user/edit/','userController@updateWeb')->name('updateUser');
Route::post('/user/update','userController@update')->name('userUpdate');
Route::get('/date', 'dateController@index')->name('dateController');
Route::post('/date', 'dateController@dateSave')->name('dateSave');
Route::get('/date/delete/{id}', 'dateController@dateDelete')->name('dateDelete');
Route::get('/price', 'priceController@index')->name('priceAll');
Route::get('/price/edit/{id}', 'priceController@edit')->name('editPrice');
Route::post('/price', 'priceController@update')->name('updatePrice');
Route::post('/send', 'fcmController@getAllTokens');

Route::get('/teraphis', 'teraphisController@index')->name('teraphisPage');
Route::post('/teraphis/update', 'teraphisController@update');
Route::get('/teraphis/new', 'teraphisController@baru');
Route::get('/teraphis/{id}', 'teraphisController@info');
Route::post('/teraphis', 'teraphisController@save');

Route::get('/search/users/{name}', 'userController@searchUsers');
Route::get('/data/user/{id}', 'userController@getDataUser');
Route::post('/save/user', 'userController@saveUserData');
Route::get('/ubah-password/{id}', 'userController@ubahPasswordUserView');
Route::post('/ubah-password', 'userController@ubahPasswordUser');

//only admin
Route::get('/user-management', 'userController@management');
});
