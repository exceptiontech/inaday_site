<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');

Route::get('projects', 'API\ProjectController@index');
Route::get('projects/{id}', 'API\ProjectController@show');

Route::get('services', 'API\ServiceController@index');
Route::get('services/{id}', 'API\ServiceController@show');

Route::get('mixtures', 'API\MixtureController@index');
Route::get('mixtures/{id}', 'API\MixtureController@show');



Route::middleware('auth:api')->group(function () {
    Route::get('user', 'PassportController@details');
	//Route::resource('departments','API\DepartmentController');
	Route::resource('wishlist','API\WishlistController');
	Route::get('cart','API\CartController@index');
	Route::get('cart/create','API\CartController@store');

});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
